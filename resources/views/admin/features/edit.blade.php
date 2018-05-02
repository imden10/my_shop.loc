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
                <a href="/master/features">Фильтры</a>
            </li>
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master/features" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
    {!! Form::model($item, ['route'=> ['features-update'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
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
                        </div>
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

@stop
@push('styles')

@endpush
@push('scripts')
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

            $scope.data = {!!$item!!}

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
                    url: "{{route('get-lang-feature-edit')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        lang: lang,
                        id:$scope.data.id
                    }
                }).then(function successCallback(response) {
                    $(".wait-spin").hide();
                    $scope.data = response.data;
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

        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        });

    });
</script>
@endpush