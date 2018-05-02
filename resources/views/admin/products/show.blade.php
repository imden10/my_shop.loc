@extends('admin.layout')

@section('main')
    <div ng-app="treeApp" ng-controller="treeCtrl">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <ol class="breadcrumb">
                <li>
                    <a href="/master">
                        <span class="fa fa-home"></span>
                    </a>
                </li>
                <li>Каталог</li>
                <li class="active">{{$title}}</li>
            </ol>
            <div class="btns-panel">
                <a href="products/create" class="btn btn-success" title="Добавить" data-toggle="tooltip" data-placement="bottom">
                    <i class="fa fa-plus"></i>
                </a>
                <a class="btn btn-warning" id="check_all" title="Выделить все" data-toggle="tooltip" data-placement="bottom">
                    <i class="fa fa-check"></i>
                </a>
                <a href="#" class="btn btn-danger disabled btn-delete-all" ng-click="deleteSelected()" title="Удалить выбранные" data-toggle="tooltip" data-placement="bottom">
                    <i class="fa fa-trash-o"></i>
                </a>
            </div>
        </section>

        {{--------------------Фильтра--------------------}}
        <div class="box box-primary add-form-box collapsed-box" style="margin: 0 15px 15px 15px">
            <div class="box-header with-border">
                <h3 class="box-title">Фильтры</h3>
                <div class="box-tools pull-right">
                    <button type="button" onfocus="this.blur();" class="btn btn-box-tool collapse-toggle-btn"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <div class="box-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_name" class="control-label">Название</label>
                                <input type="text" class="form-control" id="filter_name" name="filter_name" placeholder="Название" value="{{Input::get('filter_name')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_vendor" class="control-label">Артикул</label>
                                <input type="text" class="form-control" id="filter_vendor" name="filter_vendor" placeholder="Артикул" value="{{Input::get('filter_vendor')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_price" class="control-label">Цена (закуп.)</label>
                                <input type="text" class="form-control" id="filter_price" name="filter_price" placeholder="Цена" value="{{Input::get('filter_price')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_category" class="control-label">Категория</label>
                                <select name="filter_category" style="width: 100%;" id="filter_category" class="form-control select2">
                                    <option value="">&nbsp;</option>
                                    @foreach($categories as $item)
                                        <option @if(Input::get('filter_category') == $item->id) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                        @if(count($item->children)>0)
                                            @foreach($item->children as $child)
                                                <option @if(Input::get('filter_category') == $child->id) selected @endif value="{{$child->id}}">&nbsp;&nbsp;{{$child->name}}</option>
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_count" class="control-label">Количество</label>
                                <input type="text" class="form-control" id="filter_count" name="filter_count" placeholder="Количество" value="{{Input::get('filter_count')}}">
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label for="filter_status" class="control-label">Статус</label>
                                <select name="filter_status" style="width: 100%;" id="filter_status" class="form-control select2">
                                    <option value="">&nbsp;</option>
                                    <option @if(Input::get('filter_status') == '1') selected @endif value="1">Включено</option>
                                    <option @if(Input::get('filter_status') == '0') selected @endif value="0">Отключено</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="box-footer">
                <div class="btn-group pull-right">
                    <a href="{{route('products')}}" class="btn btn-danger">
                        <i class="fa fa-times"></i>
                    </a>
                    <button class="btn btn-primary set-filters-btn">
                        <i class="fa fa-filter"></i>
                        Фильтр
                    </button>
                </div>
            </div>
        </div>
        {{--------------------Фильтра--------------------}}

        <div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bars"></i>
				<span class="page-name">{{$title}}</span>&nbsp;|&nbsp;
				<span class="label label-success" style="margin-left: 0!important;">Всего {{count($products)}} {{ Lang::choice('товар|товара|товаров', count($products) , array(), 'ru') }}</span>
			</div>
			<div class="panel-body">
	            @if( count($products) > 0 )
                    <table class="table table-bordered table-hover table-products-sort">
                        <thead>
                        <tr>
                            <th style="vertical-align: top"><input type="checkbox" class="check-all"></th>
                            <th style="vertical-align: top">Изображение</th>
                            <th style="vertical-align: top">
                                <?
                                $order = 'asc';
                                if(Input::get('sort') == 'name' && Input::get('order') == 'asc')
                                    $order = 'desc';
                                    $class = '';
                                    if(Input::get('sort') == 'name'){
                                        $class = Input::get('order');
                                    }
                                ?>
                                {!! link_to_route('products', 'Название', array_merge(Request::all(), ['sort'=>'name','order'=>$order]), ['class'=>$class]) !!}
                            </th>
                            <th style="vertical-align: top">
                                <?
                                $order = 'asc';
                                if(Input::get('sort') == 'vendor_code' && Input::get('order') == 'asc')
                                    $order = 'desc';
                                $class = '';
                                if(Input::get('sort') == 'vendor_code'){
                                    $class = Input::get('order');
                                }
                                ?>
                                {!! link_to_route('products', 'Артикул', array_merge(Request::all(), ['sort'=>'vendor_code','order'=>$order]), ['class'=>$class]) !!}
                            </th>
                            <th style="vertical-align: top">
                                <?
                                $order = 'asc';
                                if(Input::get('sort') == 'price' && Input::get('order') == 'asc')
                                    $order = 'desc';
                                $class = '';
                                if(Input::get('sort') == 'price'){
                                    $class = Input::get('order');
                                }
                                ?>
                                {!! link_to_route('products', 'Цена', array_merge(Request::all(), ['sort'=>'price','order'=>$order]), ['class'=>$class]) !!}
                                <br>
                                <span>(Закуп. / На сайте)</span>
                            </th>
                            <th style="vertical-align: top">
                                <?
                                $order = 'asc';
                                if(Input::get('sort') == 'count' && Input::get('order') == 'asc')
                                    $order = 'desc';
                                $class = '';
                                if(Input::get('sort') == 'count'){
                                    $class = Input::get('order');
                                }
                                ?>
                                {!! link_to_route('products', 'Количество', array_merge(Request::all(), ['sort'=>'count','order'=>$order]), ['class'=>$class]) !!}
                            </th>
                            <th style="vertical-align: top">
                                <?
                                $order = 'asc';
                                if(Input::get('sort') == 'status' && Input::get('order') == 'asc')
                                    $order = 'desc';
                                $class = '';
                                if(Input::get('sort') == 'status'){
                                    $class = Input::get('order');
                                }
                                ?>
                                {!! link_to_route('products', 'Статус', array_merge(Request::all(), ['sort'=>'status','order'=>$order]), ['class'=>$class]) !!}
                            </th>
                            <th style="text-align: right; width: 200px;vertical-align: top">Управление</th>
                        </tr>
                        </thead>
                        <tbody class="table-body">
                            <tr ng-repeat="product in data" data-id="[[product.id]]">
                                <td style="vertical-align: middle;width:20px">
                                    <input type="checkbox" data-check="[[product.id]]" name="check[]" value="[[product.id]]">
                                </td>
                                <td style="vertical-align: middle">
                                    <img src="/uploads/tiny/images/products/[[product.image]]" style="height: 50px" alt="product">
                                </td>
                                <td style="vertical-align: middle">
                                    [[product.name]]
                                </td>
                                <td style="vertical-align: middle">
                                    <span class="label label-primary">
                                        [[product.vendor_code]]
                                    </span>
                                </td>
                                <td style="vertical-align: middle">
                                    [[product.price]] / [[product.pricesite]]
                                </td>
                                <td style="vertical-align: middle">
                                    <span class="label [[product.count > 10 ? 'label-success' : 'label-danger']]">
                                        [[product.count]]
                                    </span>
                                </td>
                                <td style="vertical-align: middle">
                                    [[product.status == 1 ? 'Включено' : 'Отключено']]
                                </td>
                                <td style="text-align: right;vertical-align: middle">
                                    <a href="products/edit/[[product.id]]" class="btn btn-success"
                                       title="Редактировать" data-toggle="tooltip" data-id="[[product.id]]">
                                        <i class="glyphicon glyphicon-pencil"></i>
                                    </a>
                                    <span class="btn btn-danger delete-btn-one" ng-click="delete(product)" title="Удалить" data-toggle="tooltip"
                                          data-id="[[product.id]]">
                                        <i class="fa fa-minus"></i>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    {!! $products->appends(Input::all())->render() !!}
	            @else
                    <div class="alert alert-warning" role="alert">
                        Нет записей
                    </div>
	            @endif
			</div>
		</div>
	</div>
    </div>
@endsection
@push('styles')
<link rel="stylesheet" href="{{url('bower_components/select2/dist/css/select2.min.css')}}">
@endpush

@push('scripts')
    <script src="{{url('bower_components/select2/dist/js/select2.js')}}"></script>
	<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
	<script>
        //angular
        (function() {
            'use strict';

            var app = angular.module('treeApp', [], function($interpolateProvider) {
                $interpolateProvider.startSymbol('[[');
                $interpolateProvider.endSymbol(']]');
            });

            app.controller('treeCtrl', function($scope, $http) {
                $scope.data = {!!json_encode($products->all())!!}

                $scope.options = {!! $languages !!}
                var lang = "{{Session::get('alang')}}";
                for(var i=0;i<$scope.options.length;i++){
                    if($scope.options[i].id == lang){
                        $scope.selectedOption = $scope.options[i];
                    }
                }

                $scope.remove = function (scope) {
                    scope.remove();
                };

                $scope.delete = function (node) {
                    var item = this;
                    var checked = [node.id];
                    $(".delete-btn-one[data-id="+node.id+"]").find('i').addClass('fa-spinner fa-spin');
                    $http({
                        method: 'POST',
                        url: "{{route('products-delete')}}",
                        data: {
                            _token: "{{ Session::token() }}",
                            checked: checked
                        }
                    }).then(function successCallback(response) {
                        if(response.data['status'] == false){
                            alert(response.data['error']);
                            $(".delete-btn-one[data-id="+node.id+"]").find('i').removeClass('fa-spinner fa-spin');
                        }
                        else{
                            $scope.data = response.data['products'];
                        }
                    }, function errorCallback(response) {
                        alert('Ошибка, перезагрузите страницу');
                    });
                };

                $scope.deleteSelected = function () {
                    var checked = [];
                    $('input[type="checkbox"][name*="check"]').each(function (i,elem) {
                        if ($(this).prop('checked')){
                            checked.push($(this).data('check'));
                        }
                    });
                    $(".btn-delete-all").find('i').addClass('fa-spinner fa-spin');
                    $http({
                        method: 'POST',
                        url: "{{route('products-delete')}}",
                        data: {
                            _token: "{{ Session::token() }}",
                            checked: checked
                        }
                    }).then(function successCallback(response) {
                        if(response.data['status'] == false){
                            alert(response.data['error']);
                        }
                        else{
                            $scope.data = response.data['products'];
                        }
                        $(".btn-delete-all").find('i').removeClass('fa-spinner fa-spin');
                        $('.btn-delete-all').addClass('disabled');
                    }, function errorCallback(response) {
                        alert('Ошибка, перезагрузите страницу');
                    });
                };
            });
        })();

        // jquery
        $(document).ready(function() {

            /*Инициализация select*/
            $('.select2').select2();

			/*Проверяет есть ли выделенные checkbox*/
            function check_check() {
                console.log('1');
                var checked = false;
                $('.btn-delete-all').removeClass('disabled');
                $('.table-bordered input:checkbox').each(function (i,elem) {
                    if ($(this).prop('checked')){
                        checked = true;
                    }
                });
                if (checked){
                    $('.btn-delete-all').removeClass('disabled');
                }
                else {
                    $('.btn-delete-all').addClass('disabled');
                }
            }

            // выделить все
            $("#check_all, .check-all").on( 'click', function() {
                $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length>0 );
                check_check();
            });

            $('input[type="checkbox"][name*="check"]').on('click',function () {
                check_check();
            });

            /*Открыть/закрыть панель с фильтрами*/
            $(".collapse-toggle-btn").on('click',function () {
                if($(this).find('i').hasClass('fa-minus')){
                    $(this).find('i').removeClass('fa-minus');
                    $(this).find('i').addClass('fa-plus');
                    $('.add-form-box').addClass('collapsed-box');
                }
                else {
                    $(this).find('i').removeClass('fa-plus');
                    $(this).find('i').addClass('fa-minus');
                    $('.add-form-box').removeClass('collapsed-box');
                }
            });

            function encodeQueryData(data) {
                let ret = [];
                for (let d in data)
                    if(data[d] !== ''){
                        ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
                    }
                return ret.join('&');
            }

            /*Применить фильтра*/
            $('.set-filters-btn').on('click',function () {
                var filter_name = $('#filter_name').val();
                var filter_price = $('#filter_price').val();
                var filter_vendor = $('#filter_vendor').val();
                var filter_category = $('#filter_category').val();
                var filter_count = $('#filter_count').val();
                var filter_status = $('#filter_status').val();

                var data = {
                    'filter_name'       :filter_name,
                    'filter_price'      :filter_price,
                    'filter_vendor'     :filter_vendor,
                    'filter_count'      :filter_count,
                    'filter_status'     :filter_status,
                    'filter_category'   :filter_category
                };
                var querystring = '/master/products';
                if(encodeQueryData(data)){
                    querystring += "?" + encodeQueryData(data);
                }
                window.location.href = querystring;
            });
        })
	</script>
@endpush