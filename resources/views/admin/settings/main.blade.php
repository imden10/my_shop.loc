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
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
    {!! Form::model($settings, ['route'=> ['settings-main-update'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    <div class="box box-success" style="margin: 0 15px" ng-app="treeApp" ng-controller="treeCtrl">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <input type="hidden" name="lang" value="[[lang]]">
            <input type="hidden" name="make" value="[[lang !== data.lang ? 'create' : 'update']]">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#main">Основные</a></li>
                    <li><a data-toggle="tab" href="#slider">Слайдер</a></li>
                    <li><a data-toggle="tab" href="#callback">Обратный звонок</a></li>
                    <li><a data-toggle="tab" href="#content">Контент</a></li>
                    <li><a data-toggle="tab" href="#product">Товары</a></li>
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
                    <div id="main" class="tab-pane fade in active">
                        <div class="form-group">
                            {!! Form::label('logo1', 'Верхний логотип', array('class'=>'col-sm-2 control-label', 'files' => true ) ) !!}
                            <div class="col-sm-10">
                                {!! Form::file('logo1',  array('class' => 'filestyle', 'data-value'=>'[[data.logo]]', 'data-buttonText' => 'Выберите файл', 'data-buttonName' => 'btn-primary', 'data-icon' => 'false') ) !!}
                                <span style="color: grey;">Рекомендованные размеры: ширина - 115px, высота - 65px</span>
                            </div>
                        </div>

                        <div class="form-group" ng-hide="data.logo == ''">
                            <label class="col-sm-2 control-label">Текущий лошотип</label>
                            <div class="col-sm-offset-2 col-sm-10">
                                <img style="width: 30%" src="/uploads/layout/[[data.logo]]" alt="image" class="img-responsive">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('logo2', 'Нижний логотип', array('class'=>'col-sm-2 control-label', 'files' => true ) ) !!}
                            <div class="col-sm-10">
                                {!! Form::file('logo2',  array('class' => 'filestyle', 'data-value'=>'[[data.logo2]]', 'data-buttonText' => 'Выберите файл', 'data-buttonName' => 'btn-primary', 'data-icon' => 'false') ) !!}
                                <span style="color: grey;">Рекомендованные размеры: ширина - 115px, высота - 65px</span>
                            </div>
                        </div>

                        <div class="form-group" ng-hide="data.logo2 == ''">
                            <label class="col-sm-2 control-label">Текущий лошотип</label>
                            <div class="col-sm-offset-2 col-sm-10">
                                <img style="width: 30%" src="/uploads/layout/[[data.logo2]]" alt="image" class="img-responsive">
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('slogan', 'Слоган', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                {!! Form::text('slogan', '[[data.slogan]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('email', 'Email', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                {!! Form::text('email', '[[data.email]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('phone', 'Телефон', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                {!! Form::text('phone', '[[data.phone]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::label('rights', 'Copyright', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                {!! Form::text('rights', '[[data.copy]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>

                    </div>
                    <div id="slider" class="tab-pane fade">
                        <div class="form-group">
                            {!! Form::label('speed_slider', 'Время смены слайдов', array('class'=>'col-sm-2 control-label') ) !!}
                            <div class="col-sm-10">
                                {!! Form::text('speed_slider', '[[data.speed_slider]]', array('class'=>'form-control') ) !!}
                            </div>
                        </div>
                    </div>
                    <div id="callback" class="tab-pane fade">
                        Обратный звонок
                    </div>
                    <div id="content" class="tab-pane fade">
                        Контент
                    </div>
                    <div id="product" class="tab-pane fade">

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

            $scope.data = {!!$settings!!}

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
                    url: "{{route('get-lang-settings')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        lang: lang
                    }
                }).then(function successCallback(response) {
                    $(".wait-spin").hide();
                    $scope.data = response.data;
                    $scope.lang = lang;
                    if($scope.lang !== $scope.data.lang){
                        $('#myModal').modal();
                    }
                    $('[data-toggle="tooltip"]').tooltip();
                    tinyMCE.activeEditor.setContent($scope.data.desc);
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
</script>
@endpush