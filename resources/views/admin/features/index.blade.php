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
            <a class="btn btn-warning" id="check_all" title="Выделить все" data-toggle="tooltip">
                <i class="fa fa-check"></i>
            </a>
            <a href="#" class="btn btn-danger disabled btn-delete-all" ng-click="deleteSelected()" title="Удалить выбранные" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-trash-o"></i>
            </a>
            <a href="/master" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
        <div class="box box-success add-form-box collapsed-box" style="margin: 0 15px 15px 15px">
            <div class="box-header with-border">
                <h3 class="box-title">Добавить</h3>
                <div class="box-tools pull-right">
                    <button type="button" onfocus="this.blur();" class="btn btn-box-tool collapse-toggle-btn"><i class="fa fa-plus"></i></button>
                </div>
            </div>
            <form class="form-horizontal" action="features/create" method="post">
                {!! csrf_field() !!}
                <div class="box-body">
                    <div class="form-group">
                        <label for="parent" class="col-sm-2 control-label">Создать</label>
                        <div class="col-sm-10">
                            <select name="parent" class="my_select" ng-model="parent">
                                <option ng-selected="true" value="0">Фильтр</option>
                                <option value="1">Вариант</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group" ng-show="parent == 1">
                        <label for="filter" class="col-sm-2 control-label">К фильтру</label>
                        <div class="col-sm-10">
                            <select name="filter" class="my_select_search">
                                <option ng-repeat="item in data" value="[[item.id]]">[[item.name]]</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">
                            [[parent == 1 ? 'Значение' : 'Название']]
                        </label>
                        <div class="col-sm-10">
                            <input type="text" style="width: 200px;" class="form-control" id="name" name="name">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <button type="submit" class="btn btn-success pull-right">Добавить</button>
                </div>
            </form>
        </div>

        <div class="container-fluid">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-leaf"></i>
                    <span class="page-name">Фильтры</span>&nbsp;|&nbsp;
                    <span class="label label-success" style="margin-left: 0!important;">Всего {{count(json_decode($items))}} {{ Lang::choice('фильтр|фильтра|фильтров', count(json_decode($items)) , array(), 'ru') }}</span>
                    <div class="local-menu">
                        <span class="wait-spin fa fa-spinner fa-spin"></span>
                        <select class="local-menu" ng-options="o.name for o in options" ng-model="selectedOption" ng-change="get_lang(selectedOption.id)"></select>
                    </div>
                </div>
                <div class="panel-body">
                    @if( count(json_decode($items)) > 0 )
                        <a href="#" class="btn btn-flat btn-primary" ng-click="expandAll()">Развернуть все</a>
                        <a href="#" class="btn btn-flat btn-primary" ng-click="collapseAll()">Свернуть  все</a>
                        <script type="text/ng-template" id="nodes_renderer.html">
                            <div class="tree-node">
                                <div class="pull-left tree-handle" ui-tree-handle>
                                    <apan ng-if="node.parent_id == 0 || node.parent_id == null">Фильтр</apan>
                                    <apan ng-if="node.parent_id > 0">Вариант</apan>
                                </div>
                                <div class="tree-node-content">
                                    <a ng-if="node.children && node.children.length > 0" nodrag ng-click="toggle(this)">
                                    <span class="open fa"
                                          ng-class="{'fa-plus': collapsed, 'fa-minus': !collapsed}"></span>
                                    </a>
                                    <div style="display: inline-block; margin-right: 9px;">
                                        <input class="input-check" ng-if="node.constant !== 1" data-check="[[node.id]]"
                                               name="check[]" type="checkbox" value="[[node.id]]">
                                    </div>
                                    <a class="black_link"
                                       href="/master/features/edit/[[node.id]]">[[node.name]]</a>
                                    <div class="pull-right">
                                        <a title="Edit" href="/master/features/edit/[[node.id]]"
                                           class="btn btn-success btn-flat">
                                            <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        <a href="#" class="delete btn btn-danger btn-flat" ng-if="node.constant !== 1"
                                           data-id="[[node.id]]" ng-click="delete(node)" )><span
                                                    class="fa fa-trash-o"></span></a>
                                    </div>
                                </div>
                            </div>
                            <ol ui-tree-nodes="" ng-model="node.children"  ng-class="{hidden: collapsed}" >
                                <li ng-repeat="node in node.children" ui-tree-node ng-include="'nodes_renderer.html'">
                                </li>
                            </ol>
                        </script>
                        <div ui-tree="dataOptions" data-drag-enabled="false" data-max-depth="2" id="tree-root">
                            <ol ui-tree-nodes ng-model="data">
                                <li ng-repeat="node in data" ui-tree-node data-collapsed="true" ng-include="'nodes_renderer.html'"></li>
                            </ol>
                        </div>
                        <input type="hidden" name="action" value="delete">
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
<link href="{{url('/bower_components/angular/angular-ui-tree.min.css')}}" rel="stylesheet">
<link href="{{url('/plagins/jquery.sumoselect-master/sumoselect.css')}}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="{{url('/plagins/jquery.sumoselect-master/jquery.sumoselect.min.js')}}"></script>
<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
<script src="{{url('/bower_components/angular/angular-ui-tree.min.js')}}"></script>
<script>
    /*angular*/
    (function() {
        'use strict';

        var app = angular.module('treeApp', ['ui.tree'], function($interpolateProvider) {
            $interpolateProvider.startSymbol('[[');
            $interpolateProvider.endSymbol(']]');
        });

        app.controller('treeCtrl', function($scope, $http) {
            $scope.data = {!!$items!!}
                $scope.options = {!! $languages !!}
                $scope.lang = "{{Session::get('alang')}}";
            for(var i=0;i<$scope.options.length;i++){
                if($scope.options[i].id == $scope.lang){
                    $scope.selectedOption = $scope.options[i];
                }
            }

            $scope.collapseAll = function () {
                var scope = getRootNodesScope();
                scope.collapseAll();
            };

            $scope.expandAll = function () {
                var scope = getRootNodesScope();
                scope.expandAll();
            };

            var getRootNodesScope = function () {
                return angular.element(document.getElementById("tree-root")).scope();
            };

            $scope.get_lang = function (lang) {
                $(".wait-spin").show();
                $http({
                    method: 'POST',
                    url: "{{route('get-lang-features')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        lang: lang
                    }
                }).then(function successCallback(response) {
                    $scope.data = response.data;
                    $scope.lang = lang;
                    $(".wait-spin").hide();
                }, function errorCallback(response) {
                    alert('Ошибка, перезагрузите страницу');
                });
            };

            $scope.remove = function (scope) {
                scope.remove();
            };

            $scope.delete = function (node) {
                var item = this;
                var checked = [node.id];
                $("a.delete[data-id="+node.id+"]").find('span').addClass('fa-spinner fa-spin');
                $http({
                    method: 'POST',
                    url: "{{route('features-delete')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        checked: checked
                    }
                }).then(function successCallback(response) {
                    if(response.data['status'] == false){
                        alert(response.data['error']);
                        $("a.delete[data-id="+node.id+"]").find('span').removeClass('fa-spinner fa-spin');
                    }
                    else{
                        $scope.remove(item);
                    }
                }, function errorCallback(response) {
                    alert('Ошибка, перезагрузите страницу');
                });
            };

            $scope.deleteSelected = function () {
                var checked = [];
                $('.tree-node-content input:checkbox').each(function (i,elem) {
                    if ($(this).prop('checked')){
                        checked.push($(this).data('check'));
                    }
                });
                $(".btn-delete-all").find('i').addClass('fa-spinner fa-spin');
                $http({
                    method: 'POST',
                    url: "{{route('features-delete')}}",
                    data: {
                        _token: "{{ Session::token() }}",
                        checked: checked
                    }
                }).then(function successCallback(response) {
                    if(response.data['status'] == false){
                        alert(response.data['error']);
                    }
                    else{
                        $scope.data = response.data['items'];
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
    $(document).ready(function () {

        /*Инициализация мульти селекта sumoselect*/
        $('.my_select').SumoSelect();
        $('.my_select_search').SumoSelect({
            search: true,
            searchText: 'Поиск...'
        });

        /*Проверяет есть ли выделенные checkbox*/
        function check_check() {
            var checked = false;
            $('.btn-delete-all').removeClass('disabled');
            $('.tree-node-content input:checkbox').each(function (i, elem) {
                if ($(this).prop('checked')) {
                    checked = true;
                }
            });
            if (checked) {
                $('.btn-delete-all').removeClass('disabled');
            }
            else {
                $('.btn-delete-all').addClass('disabled');
            }
        }

        // выделить все
        $("#check_all, .check-all").on('click', function () {
            $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length > 0);
            check_check();
        });

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

        $('input[type="checkbox"][name*="check"]').on('click',function () {
            check_check();
        });
    })
</script>
@endpush