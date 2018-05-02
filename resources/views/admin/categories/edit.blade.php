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
                <a href="/master/categories">Категории</a>
            </li>
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master/categories" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
    {!! Form::model($category, ['route'=> ['categories-update'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    <div class="box box-success" style="margin: 0 15px" ng-app="treeApp" ng-controller="treeCtrl">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <input type="hidden" name="lang" value="[[lang]]">
            <input type="hidden" name="id" value="[[data.id]]">
            <input type="hidden" name="make" value="[[lang !== data.lang ? 'create' : 'update']]">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_main" data-toggle="tab">Основное</a></li>
                    <li><a href="#tab_seo" data-toggle="tab">SEO</a></li>
                    <li><a href="#tab_filters" data-toggle="tab">Фильтры</a></li>
                    <li class="pull-right local-menu">
                        <select style="width: 100%;" ng-options="o.name for o in options" ng-model="selectedOption" ng-change="get_lang(selectedOption.id)"></select>
                    </li>
                    <li class="pull-right local-menu">
                        <span ng-if="lang !== data.lang" class="badge" title="Экземпляра на данном языку не существует. Для создания, внесите изменения на данном языку и нажмите сохранить" data-toggle="tooltip" data-placement="bottom">
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
                                    {!! Form::text('name', '[[data.name]]', array('class'=>'form-control') ) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('active', 'Статус', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="checkbox" ng-checked="data.status" value="1" name="active" id="active" class="form-control styler">
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('image', 'Изображение', array('class'=>'col-sm-2 control-label', 'files' => true ) ) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('image', ['class' => 'filestyle', 'data-value' => '[[data.image]]','data-buttonText' => ' Выберите файл']) !!}
                                    <span style="color: grey;">Рекомендованный размер изображения: ширина - 500px, высота - 500px</span>
                                    <div class="thumbnail" style="display: block; width: 15%; vertical-align: top; margin-top: 20px" ng-hide="data.image == 'default.jpg'">
                                        <img style="width: 100%;" alt="photo" src="/uploads/categories/[[data.image]]"
                                             alt="" data-toggle="modal" data-target="#exampleModal">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Описание', array('class'=>'col-sm-2 control-label') ) !!}
                                <div class="col-sm-10">
                                    {!! Form::textarea('description', '[[data.description]]', array('class'=>'form-control editor') ) !!}
                                    <span style="color: grey;">
                                    Загружаемые файлы и каталоги в текстовом редакторе должны содержать только латинские символы
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_seo">
                        <div class="form-group" ng-if="data.constant !== 1">
                            <label for="inputSlug" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <label class="input-group-addon" for="slug_flag" title="Включите, что бы отредактировать URL страницы" data-toggle="tooltip">
                                        <input type="checkbox" id="slug_flag">
                                    </label>
                                    <input type="text" class="form-control" disabled id="inputSlug" name="slug" value="[[data.slug]]">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMetaTitle" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputMetaTitle" name="meta_title" value="[[data.meta_title]]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMetaKeys" class="col-sm-2 control-label">Keys</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputMetaKeys" name="meta_keywords" value="[[data.meta_keys]]">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="textMetaDescr" class="col-sm-2 control-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="textMetaDescr" name="meta_description">[[data.meta_description]]</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_filters">
                        <table class="table table-hover">
                            <tbody class="tbody">
                            <tr>
                                <th>#</th>
                                <th><input type="checkbox" class="check-all"></th>
                                <th>Название</th>
                            </tr>
                            <tr ng-repeat="item in features">
                                <td>[[$index + 1]]</td>
                                <td>
                                    <input type="checkbox" name="features[]" ng-checked="cat_features.indexOf(item.id) >= 0" value="[[item.id]]">
                                </td>
                                <td>[[item.name]]</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

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
<link href="{{url('/admin/css/bootstrap-switch.min.css')}}" rel="stylesheet"/>
<link href="{{url('/bower_components/select2/dist/css/select2.min.css')}}" rel="stylesheet"/>
@endpush
@push('scripts')
<script src="{{url('/admin/js/bootstrap-switch.min.js')}}"></script>
<script src="{{url('/admin/js/bootstrap.filestyle.js')}}"></script>
<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('/bower_components/angular/angular-ui-tree.min.js')}}"></script>
<script src="{{url('/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>

    //angular
    (function() {
        'use strict';

        var app = angular.module('treeApp', ['ui.tree'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        app.controller('treeCtrl', function($scope, $http) {

            $scope.data = {!!$category!!}

            $scope.features = {!!$features!!}

            $scope.options = {!! $languages !!}

            $scope.cat_features = {!! $cat_features !!}

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
                    url: "{{route('get-lang-categories-edit')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        lang: lang,
                        id:$scope.data.id
                    }
                }).then(function successCallback(response) {
                    $(".wait-spin").hide();
                    $scope.data = response.data['category'];
                    $scope.features = response.data['features'];
                    $scope.lang = lang;
                    if($scope.lang !== $scope.data.lang){
                        $('#myModal').modal();
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    tinyMCE.activeEditor.setContent($scope.data.description);
                }, function errorCallback(response) {
                    alert('Ошибка, перезагрузите страницу');
                });
            };
        });
    })();

    /*jquery------------------------------------------------*/
    $(document).ready(function() {
        /*Стилизация checkbox*/
        $(".styler").bootstrapSwitch();

        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        });

        //Initialize Select2 Elements
        $('.select2').select2();

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

    meta_title_touched = true;
    url_touched = true;

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
</script>
@endpush