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

    <div ng-app="treeApp" ng-controller="treeCtrl">
    @include('errors.form-errors')
    {!! Form::model($category, ['route'=> ['categories-create'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    <div class="box box-success" style="margin: 0 15px">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_main" data-toggle="tab">Основное</a></li>
                    <li><a href="#tab_seo" data-toggle="tab">SEO</a></li>
                    <li><a href="#tab_filters" data-toggle="tab">Фильтры</a></li>
                    {{--<li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>--}}
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_main">
                        <div class="row">
                            <div class="form-group">
                                {!! Form::label('name', 'Название', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    {!! Form::text('name', '', array('class'=>'form-control') ) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('parent_id', 'Родительская категория', array('class'=>'col-sm-2 control-label') ) !!}
                                <div class="col-sm-10">
                                    <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%">
                                        <option value="0" selected>Нет</option>
                                        @foreach($categories as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('active', 'Статус', array('class'=>'col-md-2 col-sm-2 col-xs-12 control-label') ) !!}
                                <div class="col-md-10 col-sm-10 col-xs-12">
                                    <input type="checkbox" checked value="1" name="active" id="active" class="form-control styler">
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('image', 'Изображение', array('class'=>'col-sm-2 control-label', 'files' => true ) ) !!}
                                <div class="col-sm-10">
                                    {!! Form::file('image', ['class' => 'filestyle', 'data-value' => '','data-buttonText' => ' Выберите файл']) !!}
                                    <span style="color: grey;">Рекомендованный размер изображения: ширина - 500px, высота - 500px</span>
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('description', 'Описание', array('class'=>'col-sm-2 control-label') ) !!}
                                <div class="col-sm-10">
                                    {!! Form::textarea('description', '', array('class'=>'form-control editor') ) !!}
                                    <span style="color: grey;">
                                    Загружаемые файлы и каталоги в текстовом редакторе должны содержать только латинские символы
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab_seo">
                        @if ($category->constant !== 1)
                            <div class="form-group">
                                <label for="inputSlug" class="col-sm-2 control-label">URL</label>
                                <div class="col-sm-10">
                                    <div class="input-group">
                                        <span class="input-group-addon">&nbsp;/&nbsp;</span>
                                        <input type="text" class="form-control" id="inputSlug" name="slug">
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="inputMetaTitle" class="col-sm-2 control-label">Title</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputMetaTitle" name="meta_title">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputMetaKeys" class="col-sm-2 control-label">Keys</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputMetaKeys" name="meta_keywords">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="textMetaDescr" class="col-sm-2 control-label">Descriptions</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="textMetaDescr" name="meta_description"></textarea>
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
                                <tr ng-repeat="item in data">
                                    <td>[[$index + 1]]</td>
                                    <td>
                                        <input type="checkbox" name="features[]" value="[[item.id]]">
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
    </div>

    @include('admin.tinymce_init')

@stop
@push('styles')
<link rel="stylesheet" href="{{url('bower_components/select2/dist/css/select2.min.css')}}">
<link rel="stylesheet" href="{{url('admin/css/bootstrap-switch.min.css')}}">
@endpush
@push('scripts')
<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap-switch.min.js')}}"></script>
<script src="{{url('admin/js/bootstrap.filestyle.js')}}"></script>
<script src="{{url('bower_components/select2/dist/js/select2.js')}}"></script>

<script>

    //angular
    (function() {
        'use strict';

        var app = angular.module('treeApp', [], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        app.controller('treeCtrl', function($scope, $http) {
            $scope.data = {!!$features!!}
        });
    })();

    /*jquery------------------------------------------------*/
    $(document).ready(function() {
        /*Стилизация checkbox*/
        $(".styler").bootstrapSwitch();

        /*Инициализация select*/
        $('.select2').select2();

        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        })

    });

    meta_title_touched = false;
    url_touched = false;

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