@extends('frontend.layout')

@section('main')
    <div class="container top-container">
        <div class="row">
            <div class="col-md-12 los-sm-12 col-xs-12">
                <div class="breadcrumbs">
                    <a href="/">Главная</a>
                    <span class="slash">|</span>
                    <? $i = 1 ?>
                    @if(count($breadcrumbs) > 0)
                        @foreach($breadcrumbs as $item)
                            @if($i < count($breadcrumbs))
                                <a href="/catalog/{{$item->slug}}">{{$item->name}}</a>
                                <span class="slash">|</span>
                            @else
                                <a href="/catalog/{{$item->slug}}">{{$item->name}}</a>
                            @endif
                            <? $i++ ?>
                        @endforeach
                    @else
                        <span>Каталог</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <aside class="col-md-3 col-sm-4 col-xs-12">
                {{--{{dd($categories)}}--}}
                <span class="caption">Категории</span>
                <ul class="catalog-menu">
                    @foreach($categories as $category)
                        <li class="main-li @if(in_array($category->id,$active_categories_menu_ids)) active open @endif">
                            <a href="/catalog/{{$category->slug}}">{{$category->name}}</a>
                            @if(count($category->children)>0)
                            <i class="fa fa-angle-down btn-open-menu"></i>
                            <ul class="sub-menu" @if(in_array($category->id,$active_categories_menu_ids)) style="display: block" @endif>
                                @foreach($category->children as $cat_child)
                                    <li class="sub-li @if(in_array($cat_child->id,$active_categories_menu_ids)) active open @endif">
                                        <a href="/catalog/{{$cat_child->slug}}">{{$cat_child->name}}</a>
                                        @if(count($cat_child->children)>0)
                                            <i class="fa fa-angle-down btn-open-sub-menu"></i>
                                            <ul class="sub-child-menu" @if(in_array($cat_child->id,$active_categories_menu_ids)) style="display:block" @endif>
                                                @foreach($cat_child->children as $child)
                                                    <li class="sub-child-li @if(in_array($child->id,$active_categories_menu_ids)) active @endif">
                                                        <a href="/catalog/{{$child->slug}}">{{$child->name}}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                        </li>
                    @endforeach
                </ul>
                <div class="features-container">
                    <i class="fa fa-close visible-xs" onClick="$(this).parent('.features-container').parent('aside').removeClass('mobile-filter')"></i>
                    @include('frontend._filter',['mode'=>'md'])
                </div>
            </aside>
            <div class="content col-md-9 col-sm-8 col-xs-12">
                <!--Блок сортировки-------BEGIN-------------------------------------->
                <div class="sort-box row">
                    <div class="type-view-block col-md-4 col-sm-3 hidden-xs">
                        <div class="type-view">
                            <div class="btn-select list @if (Session::get('view') == 'list') active @endif">
                                <i class="fa fa-th-list"></i>
                            </div>
                            <div class="btn-select grid @if (Session::get('view') == 'grid') active @endif">
                                <i class="fa fa-th-large"></i>
                            </div>
                        </div>
                    </div>
                    <div class="filter-btn-block hidden-lg hidden-md hidden-sm col-xs-5">
                        <button onClick="$('aside').addClass('mobile-filter')">Фильтры</button>
                    </div>
                    <div class="sort-block col-md-7 col-sm-7 col-xs-7">
                        <form method="get" style="display: inline-block" id="form_sort">
                            <select class="select-sort" name="sort" onChange="getElementById('form_sort').submit()">
                                <option @if(Input::get('sort') == 'all') selected @endif value="all">По умолчанию</option>
                                <option @if(Input::get('sort') == 'price_asc') selected @endif value="price_asc">Дешевые</option>
                                <option @if(Input::get('sort') == 'price_desc') selected @endif value="price_desc">Дорогие</option>
                                <option @if(Input::get('sort') == 'name_asc') selected @endif value="name_asc">Имя (А-Я)</option>
                                <option @if(Input::get('sort') == 'name_desc') selected @endif value="name_desc">Имя (Я-А)</option>
                            </select>
                            @if (Request::has('checked'))
                                @foreach($features as $item)
                                    @foreach($item->children as $var)
                                        @if (in_array($var->id,Request::get('checked')))
                                            <input type="hidden" name="checked[]" value="{{$var->id}}">
                                        @endif
                                    @endforeach
                                @endforeach
                            @endif
                            @if (Request::has('price_min'))
                                @if ((Request::get('price_min')!=$minPrice)||(Request::get('price_max')!=$maxPrice))
                                    <input type="hidden" name="price_min" value="{{ Request::get('price_min') }}">
                                    <input type="hidden" name="price_max" value="{{ Request::get('price_max') }}">
                                @endif
                            @endif
                        </form>
                    </div>
                    <div class="view-count-block col-md-1 col-sm-2 hidden-xs">
                        <form action="" method="post" style="display: inline-block" id="form_paginate_count">
                            {!! csrf_field() !!}
                            <select class="select-count-view" name="paginate_count" onChange="getElementById('form_paginate_count').submit()">
                                <option @if(Session::get('paginate_count')=='9') selected @endif value="9">9</option>
                                <option @if(Session::get('paginate_count')=='18') selected @endif value="18">18</option>
                                <option @if(Session::get('paginate_count')=='36') selected @endif value="36">36</option>
                            </select>
                        </form>
                    </div>
                </div>
                <!--Блок сортировки----END----------------------------------------->
                <!---------------BEGIN------------Контент продукты--------------->
                <div class="products-container">
                    @foreach($products as $product)
                        <div class="@if (Session::get('view') == 'grid') product-block @elseif(Session::get('view') == 'list') product-block-list @endif">
                            <a href="#" class="img-a">
                                <div class="img" style="background-image: url('/uploads/tiny/images/products/{{$product->image}}')"></div>
                            </a>
                            <div class="info-list">
                                <div class="info">
                                    <a href="#" class="name">{{str_limit($product->name,140)}}</a>
                                    <div class="description">{!! str_limit($product->description,200) !!}</div>
                                    <span class="price">{{$product->pricesite}} грн.</span>
                                </div>
                                <div class="btns-box">
                                    <div class="to-cart-btn {{--in-cart--}}"></div>
                                    <div class="to-favorite {{--in-favorite--}}">
                                        <span class="fa fa-heart"></span>
                                    </div>
                                </div>
                                <div class="stickers">
                                    <div class="sticker new"><span>Новинка</span></div>
                                    <div class="sticker hit"><span>Хит<br> продаж</span></div>
                                    <div class="sticker sale"><span>Акция</span></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            <!---------------END------------Контент продукты--------------->
                {{------------------pagination----BEGIN--------------}}
                <div ng-app="myApp">
                    <div ng-controller="paginateCtrl">
                        <div class="pagination-box">
                            <div class="more-link">
                                <a href="javascript:void(0)" ng-click="more()" ng-show="skip < paginate.total">
                                    Показать еще
                                </a>
                            </div>
                            <div class="pagination" ng-if="paginate.last_page > 1">
                                <a ng-show="paginate.current_page > 3" href="{{Request::url()}}?page=1"
                                   class="last-page">1</a>
                                <span ng-show="paginate.current_page > 3">...</span>
                                <a href="{{Request::url()}}?page=[[i]]" ng-repeat="i in range" class="n-page"
                                   ng-class="{active : paginate.current_page == i}">
                                    [[ i ]]
                                </a>
                                <span ng-show="(paginate.current_page + 2) < paginate.last_page">...</span>
                                <a ng-show="(paginate.current_page + 2) < paginate.last_page"
                                   href="{{Request::url()}}?page=[[paginate.last_page]]" class="last-page">[[paginate.last_page]]</a>
                            </div>
                        </div>
                    </div>
                </div>
                {{------------------pagination----END----------------}}
            </div>
        </div>
    </div>

    <div class="container body-box">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <p>
                    description category
                </p>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{url('/frontend/css/catalog.css')}}">
    <link rel="stylesheet" href="{{url('plagins/jquery.ui-slider/slider.css')}}">
    <link rel="stylesheet" href="{{url('/plagins/jQueryFormStyler-master/dist/jquery.formstyler.css')}}"/>
@endpush

@push('scripts')
<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('/plagins/jquery.ui-slider/jquery.ui-slider.js')}}"></script>
<script src="{{url('/plagins/jQueryFormStyler-master/dist/jquery.formstyler.min.js')}}"></script>
<script src="{{url('/frontend/js/catalog.js')}}"></script>
<script>
    (function() {
        'use strict';

        var app = angular.module('myApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        app.controller('paginateCtrl', function($scope, $http) {

            $scope.paginate = {!! $products->toJSON() !!};
            var count_more = 3;/*По сколько доставать*/
            var per_page = $scope.paginate.per_page; /*Количество на странице*/
            $scope.skip = $scope.paginate.current_page * per_page; /*По сколько пропускать*/
            var pages = [];
            for(var i=1;i<=$scope.paginate.last_page;i++) {
                if( Math.abs($scope.paginate.current_page - i) <= 2 ){
                    pages.push(i);
                }
            }
            $scope.range = pages;

            $scope.more = function () {
                if($scope.skip >= $scope.paginate.total){
                    exit;
                }
                $http({
                    method: 'POST',
                    url: '/get-product',
                    data: {
                        _token: "{{ Session::token() }}",
                        skip: $scope.skip,
                        count_more:count_more
                    }
                }).then(function successCallback(response) {
                    $('.products-container').append(response.data['res']);
                    $scope.skip += response.data['more'];
                    if($scope.skip > ($scope.paginate.current_page * per_page)){
                        $scope.paginate.current_page = Math.ceil(($scope.skip)/per_page);
                        pages = [];
                        for(var i=1;i<=$scope.paginate.last_page;i++) {
                            if( Math.abs($scope.paginate.current_page - i) <= 2 ){
                                pages.push(i);
                            }
                        }
                        $scope.range = pages;
                        window.history.pushState("object or string", "Title", "{{Request::url()}}?page="+$scope.paginate.current_page);
                    }
                }, function errorCallback(response) {
                    alert('Ошибка, перезагрузите страницу');
                });
            }
        });
    })();

    var min_price = $('.price-box.md-mode').find('#minCost-md').val();
    var max_price = $('.price-box.md-mode').find('#maxCost-md').val();

    function sendView(view) {
        $.ajax({
            url: '/catalog/setview',
            type: 'post',
            dataType: 'json',
            data: {
                _token: "{{csrf_token()}}",
                view:view
            },
            success: function(json){
                console.log(json);
                if (json.status){

                }
            }
        });
    }

    $(document).ready(function () {
        /*Инициализация price-range в фильтре диапазон цены ***MD-Режим*** BEGIN */
        $("#price-range-md").slider({
            min:{{$minPrice}},
            max:{{$maxPrice}},
            values: [min_price,max_price],
            range: true,
            step: 0.01,
            stop: function(event, ui) {
                min = $("#price-range-md").slider("values",0);
                max = $("#price-range-md").slider("values",1);
                $("input#minCost-md").val(min);
                $("input#maxCost-md").val(max);
                $(".price-block-min").text(min);
                $(".price-block-max").text(max);
            },
            slide: function(event, ui){
                min = $("#price-range-md").slider("values",0);
                max = $("#price-range-md").slider("values",1);
                $("input#minCost-md").val(min);
                $("input#maxCost-md").val(max);
                $(".price-block-min").text(min);
                $(".price-block-max").text(max);
            }
        });

        $('.styler').styler();

        /*Присваеваем значение с инпутов ползунку и алертам*/
        $("input#minCost-md").keyup(function () {
            var min = $("input#minCost-md").val();
            $("#price-range-md").slider("values",0,min);
            $(".price-block-min").text(min);
        });
        $("input#maxCost-md").keyup(function () {
            var max = $("input#maxCost-md").val();
            $("#price-range-md").slider("values",1,max);
            $(".price-block-max").text(max);
        });

        /*Инициализация select сортировки на странице продукты*/
        $('.select-sort').styler();

        /*Инициализация select показывать по 12-24-48 на странице продукты*/
        $('.select-count-view').styler();

        /*Меняем класс на отображения товаров list/grid*/
        $('.btn-select.list').on('click',function () {
            $(this).addClass('active');
            $('.btn-select.grid').removeClass('active');
            $('.product-block').addClass('product-block-list');
            $('.product-block-list').removeClass('product-block');
            sendView('list');
        });
        $('.btn-select.grid').on('click',function () {
            $(this).addClass('active');
            $('.btn-select.list').removeClass('active');
            $('.product-block-list').addClass('product-block');
            $('.product-block').removeClass('product-block-list');
            sendView('grid');
        });

        $('.pagination-box').fadeIn(500);

        /*Удаляем фильтр*/
        $('.sf-btn-close.filter').on('click',function () {
            var id = $(this).data('id');
            $("input:checkbox[value="+id+"]").prop('checked',false);
            $(this).parent('li').fadeOut(300);
            $('#form_filters_md').submit();
        });

        /*Удаляем фильтр цена*/
        $('.sf-btn-close.price').on('click',function () {
            $("#minCost-md").val('{{ $minPrice }}');
            $("#maxCost-md").val('{{ $maxPrice }}');
            $(this).parent('li').fadeOut(300);
            $('#form_filters_md').submit();
        });

    });
</script>
@endpush