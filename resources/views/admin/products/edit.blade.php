@extends('admin.layout')

@section('main')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <ol class="breadcrumb">
            <li>
                <a href="/master">
                    <span class="fa fa-home"></span>
                </a>
            </li>
            <li>Каталог</li>
            <li>
                <a href="/master/products">Товары</a>
            </li>
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('#inputSlug').prop('disabled',false);$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master/products" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    <div ng-app="treeApp" ng-controller="treeCtrl">
    @include('errors.form-errors')
    {!! Form::model($product, ['route'=> ['products-update'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    <div class="box box-success" style="margin: 0 15px">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <input type="hidden" name="lang" value="[[lang]]">
            <input type="hidden" name="id" value="[[product.id]]">
            <input type="hidden" name="make" value="[[lang !== product.lang ? 'create' : 'update']]">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_main" data-toggle="tab">Основное</a></li>
                    <li><a href="#tab_data" data-toggle="tab">Данные</a></li>
                    <li><a href="#tab_filters" data-toggle="tab">Фильтры</a></li>
                    <li><a href="#tab_attributes" data-toggle="tab">Атрибуты</a></li>
                    <li><a href="#tab_images" data-toggle="tab">Изображения</a></li>
                    <li><a href="#tab_other" data-toggle="tab">Дополнительно</a></li>
                    <li class="pull-right local-menu">
                        <select style="width: 100%;" ng-options="o.name for o in options" ng-model="selectedOption" ng-change="get_lang(selectedOption.id)"></select>
                    </li>
                    <li class="pull-right local-menu">
                        <span ng-if="lang !== product.lang" class="badge" title="Экземпляра на данном языку не существует. Для создания, внесите изменения на данном языку и нажмите сохранить" data-toggle="tooltip" data-placement="bottom">
                            <i class="fa fa-info"></i>
                        </span>
                        <span class="fa fa-spinner fa-spin wait-spin"></span>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_main">
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('name', 'Название', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    {!! Form::text('name', '[[product.name]]', array('class'=>'form-control') ) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Описание', array('class'=>'col-sm-2 control-label') ) !!}
                                <div class="col-sm-10">
                                    {!! Form::textarea('description', '[[product.description]]', array('class'=>'form-control editor') ) !!}
                                    <span style="color: grey;">
                                    Загружаемые файлы и каталоги в текстовом редакторе должны содержать только латинские символы
                                </span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputMetaTitle" class="col-sm-2 control-label">Meta Title</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="[[product.meta_title]]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputMetaKeys" class="col-sm-2 control-label">Meta Keys</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="inputMetaKeys" name="meta_keys" value="[[product.meta_keys]]">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="textMetaDescr" class="col-sm-2 control-label">Meta Descriptions</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" id="textMetaDescr" name="meta_description">[[product.meta_description]]</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('status', 'Статус', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="checkbox" ng-checked="product.status" value="1" name="status" id="status" class="form-control styler">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_data">
                        <div class="form-group">
                            <label for="inputSlug" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <label class="input-group-addon" for="slug_flag" title="Включите, что бы отредактировать URL страницы" data-toggle="tooltip">
                                        <input type="checkbox" id="slug_flag">
                                    </label>
                                    <input type="text" class="form-control" disabled id="inputSlug" name="slug" value="[[product.slug]]">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('categories', 'Категория', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                <select name="categories[]" id="categories" multiple class="form-control select2" style="width: 100%">
                                    @foreach($categories as $item)
                                        <option @if(in_array($item->id,$categories_ids)) selected @endif value="{{$item->id}}">{{$item->name}}</option>
                                        @if(count($item->children)>0)
                                            @foreach($item->children as $child)
                                                <option @if(in_array($child->id,$categories_ids)) selected @endif value="{{$child->id}}">{{$item->name}} > {{$child->name}}</option>
                                                @if(count($child->children)>0)
                                                    @foreach($child->children as $child2)
                                                        <option @if(in_array($child2->id,$categories_ids)) selected @endif value="{{$child2->id}}">{{$item->name}} > {{$child->name}} > {{$child2->name}}</option>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('price', 'Цена', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                {!! Form::text('price', '[[product.price]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('pricesite', 'Цена на сайте', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                {!! Form::text('pricesite', '[[product.pricesite]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('count', 'Количество на складе', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                {!! Form::text('count', '[[product.count]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('vendor_code', 'Артикул', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                {!! Form::text('vendor_code', '[[product.vendor_code]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_filters">

                    </div>
                    <div class="tab-pane" id="tab_attributes">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr style="color:#337ab7">
                                <th style="width: 300px;">Имя</th>
                                <th>Значение</th>
                                <th style="text-align: right; min-width: 100px">Управление</th>
                            </tr>
                            </thead>
                            <tbody class="table-body table-attributes">
                                <tr>
                                    <td colspan="3" style="text-align: right">
                                        <button type="button" class="btn btn-primary attribute_add_btn" title="Добавить"
                                                data-toggle="tooltip">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr ng-repeat="attr in attributes">
                                    <td style="vertical-align:middle">
                                        <input type="text" class="form-control" name="attribute_name[]" ng-value="attr.name">
                                    </td>
                                    <td style="vertical-align:middle">
                                        <input type="text" class="form-control" name="attribute_value[]" ng-value="attr.value">
                                    </td>
                                    <td style="text-align:right;width:100px">
                                        <button type="button" class="btn btn-danger attribute_delete_btn" title="Удалить" data-toggle="tooltip">
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane" id="tab_images">
                        <h4>Главное изображение</h4>
                        <input type="hidden" id="image_main" value="{{$images[0]->image}}" name="image_main">
                        <ul class="mailbox-attachments clearfix">
                            <li>
                                <span class="mailbox-attachment-icon has-img">
                                    <img id="images_src_main" src="/uploads/tiny/images/products/{{$images[0]->image}}" alt="">
                                    <div class="load-btn" data-val="main" data-val="0">
                                        <div class="vertical-align">
                                            <span>Загрузить</span>
                                            <i class="ion-android-upload"></i>
                                        </div>
                                    </div>
                                </span>
                                <div class="mailbox-attachment-info">
                                    <a href="#" id="images_name_main" class="mailbox-attachment-name">
                                        {{$images[0]->image}}
                                    </a>
                                    <input type="text" name="images_alt[]" id="image_main_alt" placeholder="alt" value="{{$images[0]->alt}}">
                                    <input type="hidden" id="images_main" value="{{$images[0]->image}}" name="images[]">
                                    <span class="mailbox-attachment-size">
                                        &nbsp;
                                        <a href="#" id="clear_main_btn" class="btn btn-danger btn-xs pull-right" title="Стереть" data-toggle="tooltip">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </span>
                                </div>
                            </li>
                        </ul>
                        <hr>
                        <h4 style="display:inline-block">Дополнительные изображения</h4>
                        <div style="text-align: right; margin-bottom: 10px;display: inline-block;float: right">
                            <a href="#" class="btn btn-success add-images-btn" title="Добавить изображение" data-toggle="tooltip">
                                <span class="fa fa-plus"></span>
                            </a>
                            <a class="btn btn-warning" id="check_all" title="Выделить все" data-toggle="tooltip">
                                <i class="fa fa-check"></i>
                            </a>
                            <a href="#" class="btn btn-danger disabled btn-delete-all" title="Удалить выбранные" data-toggle="tooltip">
                                <i class="fa fa-trash-o"></i>
                            </a>
                        </div>
                        <ul class="mailbox-attachments clearfix additional-images">
                            @foreach($images as $key => $image)
                                @if($image->main !== 1)
                                    <li>
                                        <span class="mailbox-attachment-icon has-img">
                                            <img id="images_src_{{$key}}" data-image={{$image->image}} src="/uploads/tiny/images/products/{{$image->image}}" alt="">
                                            <div class="load-btn" data-val="other" data-id={{$key}}>
                                                <div class="vertical-align">
                                                    <span>Загрузить</span>
                                                    <i class="ion-android-upload"></i>
                                                </div>
                                            </div>
                                        </span>
                                        <div class="mailbox-attachment-info">
                                            <a href="#" id="images_name_{{$key}}" class="dop_image">
                                                {{$image->image}}
                                            </a>
                                            <input type="text" class="image-alt" name="images_alt[]" placeholder="alt" value="{{$image->alt}}">
                                            <input type="hidden" class="image_input" id="images_{{$key}}" name="images[]" value="{{$image->image}}">
                                            <span class="mailbox-attachment-size">
                                                &nbsp;
                                                <a href="#" id="clear_img_btn" class="btn btn-danger btn-xs pull-right" title="Удалить" data-toggle="tooltip">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                <a href="#" class="btn btn-success btn-xs pull-right set-main-btn" title="Сделать главным" data-toggle="tooltip">
                                                    <i class="ion-image"></i>
                                                </a>
                                                <span class="pull-right" title="Выделить" data-toggle="tooltip">
                                                    <input type="checkbox" class="check">
                                                </span>
                                            </span>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-pane" id="tab_other">
                        <div class="form-group">
                            {!! Form::label('dropshipping', 'Дропшипинг', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                {!! Form::text('dropshipping', '[[product.dropshipping]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Примичание</h4>
                </div>
                <div class="modal-body">
                    <p>Экземпляра на данном языку не существует. Для создания, внесите изменения, в соответствующие поля на данному языку и нажмите сохранить.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Ok</button>
                </div>
            </div>

        </div>
    </div>

    @include('admin.tinymce_init')

@stop
@push('styles')
<link rel="stylesheet" href="{{url('bower_components/select2/dist/css/select2.css')}}">
<link rel="stylesheet" href="{{url('admin/css/bootstrap-switch.min.css')}}">
<link href="{{url('/plagins/jquery.sumoselect-master/sumoselect.css')}}" rel="stylesheet"/>
@endpush
@push('scripts')
<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap-switch.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap.filestyle.js')}}"></script>
<script src="{{url('bower_components/select2/dist/js/select2.js')}}"></script>
<script src="{{url('/plagins/jquery.sumoselect-master/jquery.sumoselect.min.js')}}"></script>

<script>
    var image_conter = {{$key}}+1;
    var meta_title_touched = false;
    var url_touched = true;
    //angular
    (function() {
        'use strict';

        var app = angular.module('treeApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        app.controller('treeCtrl', function($scope, $http) {

                $scope.product      = {!!$product!!}
                $scope.attributes   = {!!$attributes!!}

                $scope.options = {!! $languages !!}

                $scope.lang = "{{Session::get('alang')}}";
                for(var i=0;i<$scope.options.length;i++){
                    if($scope.options[i].id == $scope.lang){
                        $scope.selectedOption = $scope.options[i];
                    }
                }

            $scope.get_lang = function (lang) {
                $(".wait-spin").show();
                $http({
                    method: 'POST',
                    url: "{{route('get-lang-products-edit')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        lang: lang,
                        id:$scope.product.id
                    }
                }).then(function successCallback(response) {
                    $(".wait-spin").hide();
                    $scope.product      = response.data['product'];
                    $scope.attributes   = response.data['attr'];
                    $scope.lang         = lang;
                    if($scope.lang !== $scope.product.lang){
                        $('#myModal').modal();
                    }
                    $('.local-menu').find('.badge').tooltip();
                    tinyMCE.activeEditor.setContent($scope.product.description);
                }, function errorCallback(response) {
                    alert('Ошибка, перезагрузите страницу');
                });
            };
        });
    })();

    /*jquery------------------------------------------------*/
    $(document).ready(function() {

        /*Проверяет есть ли выделенные checkbox*/
        function check_check() {
            console.log('sdf');
            var checked = false;
            $('.btn-delete-all').removeClass('disabled');
            $('#tab_images .check').each(function (i,elem) {
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

        /*событие по чекбоксам дополнительных изображений*/
        $('#tab_images').on('click','.check',function () {
            check_check();
        });

        /*Стилизация checkbox*/
        $(".styler").bootstrapSwitch();

        /*Инициализация select*/
        $('.select2').select2();

        /*Получить фильтры при выборе категорий*/
        $("#categories").on('change',function () {
            var ids = $(this).val();
            $.ajax({
                url: "{{route('get-features')}}",
                type: 'post',
//                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    ids:ids,
                    variants:"{{$features_ids}}"
                },
                success: function(data){
                    $('#tab_filters').html(data);
                    $('.select2').select2();
                }
            });
        });

        /*Подгрузить фильтра*/
        $("#categories").trigger('change');

        $('.table-attributes').on('click','.attribute_delete_btn',function () {
            $(this).parent('td').parent('tr').remove();
        });

        $('.attribute_add_btn').on('click',function () {
            addAttribute();
        });

        $('.add-images-btn').on('click',function (e) {
            e.preventDefault();
            addImage();
        });

        /*Загрузка изображений*/
        $('#tab_images').on('click','.load-btn',function () {
            var main = $(this).data('val');
            var id = $(this).data('id');
            moxman.browse({
                rootpath:'/images/products/',
                view:'thumbs',
                disabled_tools:'create',
                oninsert: function(args) {
                    if (main == 'main'){
                        $('#image_main').val(args.focusedFile.name);
                        $('#images_main').val(args.focusedFile.name);
                        $('#images_name_main').text(args.focusedFile.name);
                        $('#images_src_main').attr('src','/uploads/tiny/images/products/'+args.focusedFile.name);
                    }
                    else{
                        $('#images_'+id).val(args.focusedFile.name);
                        $('#images_src_'+id).attr('src','/uploads/tiny/images/products/'+args.focusedFile.name);
                        $('#images_src_'+id).data('image',args.focusedFile.name);
                        $('#images_name_'+id).text(args.focusedFile.name);
                    }
                }
            });
        });

        /*Очистка главного изображения*/
        $("#clear_main_btn").on('click',function (e) {
            e.preventDefault();
            $('#image_main').val("noimage.jpg");
            $('#images_main').val("noimage.jpg");
            $('#images_name_main').text("noimage.jpg");
            $('#images_src_main').attr('src','/uploads/tiny/images/products/noimage.jpg');
            $('#image_main_alt').val('');
        });

        /*Удаление дополнительного изображения*/
        $("#tab_images").on('click','#clear_img_btn',function (e) {
            e.preventDefault();
            $(this).parent('span').parent('div').parent('li').remove();
        });

        /*Удаление выделенных доп. изображений*/
        $('.btn-delete-all').on('click',function (e) {
            e.preventDefault();
            $('#tab_images .check').each(function (i,elem) {
                if ($(this).prop('checked')){
                    $(this).parent('span').parent('span').parent('div').parent('li').remove();
                }
            });
            check_check();
        });

        /*Сделать главное изображение*/
        $('#tab_images').on('click','.set-main-btn',function (e) {
            e.preventDefault();
            var current_main_name = $('#image_main').val();
            var current_main_alt = $('#image_main_alt').val();

            var this_name = $(this).parent('span').parent('div').parent('li').find('.has-img').find('img').data('image');
            var this_alt = $(this).parent('span').parent('div').find('.image-alt').val();

            $('#image_main').val(this_name);
            $('#images_main').val(this_name);
            $('#images_name_main').text(this_name);
            $('#images_src_main').attr('src','/uploads/tiny/images/products/'+this_name);
            $('#image_main_alt').val(this_alt);

            $(this).parent('span').parent('div').parent('li').find('.has-img').find('img').data('image',current_main_name);
            $(this).parent('span').parent('div').parent('li').find('.has-img').find('img').attr('src','/uploads/tiny/images/products/'+current_main_name);
            $(this).parent('span').parent('div').find('.dop_image').text(current_main_name);
            $(this).parent('span').parent('div').find('.image-alt').val(current_main_alt);
            $(this).parent('span').parent('div').find('.image_input').val(current_main_name);
        });

        $("#slug_flag").on('click',function () {
            if($(this).is(":checked")){
                $("#inputSlug").prop("disabled",false);
                url_touched = false;
                meta_title_touched = false;
            }
            else {
                $("#inputSlug").prop("disabled",true);
                url_touched = true;
                meta_title_touched = true;
            }
        });

    });

    /*Выделить все доп. изображений*/
    $('#check_all').on('click',function (e) {
        e.preventDefault();
        $('#tab_images .check').each(function (i,elem) {
            $(this).prop('checked',true);
        });
        check_check();
    });



    $('input[name="slug"]').change(function () {
        url_touched = true;
    });


    $('input[name="name"]').keyup(function () {
        if (!url_touched)
            $('input[name="slug"]').val(generate_url('input[name="name"]'));

        if (!meta_title_touched)
            $('input[name="meta_title"]').val($('input[name="name"]').val());

    });

    $('input[name="meta_title"]').change(function () {
        meta_title_touched = true;
    });

    // выделить все
    $(".check-all").on('click', function () {
        $('input[type="checkbox"][name*="features"]').prop('checked', $('input[type="checkbox"][name*="features"]:not(:checked)').length>0 );
    });

    /*Добавить новый атриут*/
    function addAttribute(){
        var tr = "";
        tr += "<tr style='background-color:eee'>";
        tr +=   "<td style='vertical-align:middle'>";
        tr +=       "<input type='text' class='form-control' name='attribute_name[]'>";
        tr +=   "</td>";
        tr +=   "<td style='vertical-align:middle'>";
        tr +=       "<input type='text' class='form-control' name='attribute_value[]'>";
        tr +=   "</td>";
        tr +=   "<td style='text-align:right;width:100px'>";
        tr +=       "<button type='button' class='btn btn-danger attribute_delete_btn' title='Удалить' data-toggle='tooltip'>";
        tr +=           "<i class='fa fa-trash-o'></i>";
        tr +=       "</button>";
        tr +=   "</td>";
        tr += "</tr>";
        $(tr).insertAfter($(".table-attributes tr:first"));
        $('[data-toggle="tooltip"]').tooltip();
    }

    /*Добавить новое изображение*/
    function addImage(){
        var li = "";
        li += "<li>";
        li +=   "<span class='mailbox-attachment-icon has-img'>";
        li +=       "<img id='images_src_"+image_conter+"' data-image='noimage.jpg' src='/uploads/tiny/images/products/noimage.jpg' alt=''>";
        li +=       "<div class='load-btn' data-val='other' data-id='"+image_conter+"'>";
        li +=           "<div class='vertical-align'>";
        li +=               "<span>Загрузить</span>";
        li +=               "<i class='ion-android-upload'></i>";
        li +=           "</div>";
        li +=       "</div>";
        li +=   "</span>";
        li +=   "<div class='mailbox-attachment-info'>";
        li +=       "<a href='#' id='images_name_"+image_conter+"' class='dop_image'>";
        li +=           "noimage.jpg";
        li +=       "</a>";
        li +=       "<input type='text' class='image-alt' name='images_alt[]' placeholder='alt'>";
        li +=       "<input type='hidden' class='image_input' id='images_"+image_conter+"' name='images[]' value='noimage.jpg'>";
        li +=       "<span class='mailbox-attachment-size'>";
        li +=           "&nbsp;";
        li +=           "<a href='#' id='clear_img_btn' class='btn btn-danger btn-xs pull-right' title='Удалить' data-toggle='tooltip'>";
        li +=               "<i class='fa fa-trash'></i>";
        li +=           "</a>";
        li +=           "<a href='#' class='btn btn-success btn-xs pull-right set-main-btn' title='Сделать главным' data-toggle='tooltip'>";
        li +=               "<i class='ion-image'></i>";
        li +=           "</a>";
        li +=           "<span class='pull-right' title='Выделить' data-toggle='tooltip'>";
        li +=               "<input type='checkbox' class='check'>";
        li +=           "</span>";
        li +=       "</span>";
        li +=   "</div>";
        li += "</li>";
//        $(".additional-images").html($(".additional-images").html()+li);
        $(".additional-images").append(li);
        $('[data-toggle="tooltip"]').tooltip();
        image_conter++;
    }
</script>
@endpush