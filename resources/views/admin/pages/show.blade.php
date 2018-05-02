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
                <li class="active">Страницы</li>
                <li class="active">{{$title}}</li>
            </ol>
            <div class="btns-panel">
                <a href="{{$page_type}}/create" class="btn btn-success" title="Добавить" data-toggle="tooltip" data-placement="bottom">
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
        <div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-bars"></i>
				<span class="page-name">{{$title}}</span>&nbsp;|&nbsp;
				<span class="label label-success" style="margin-left: 0!important;">Всего {{$count_pages}} {{ Lang::choice('Страница|Страницы|Страниц', $count_pages , array(), 'ru') }}</span>
				&nbsp
                <div class="local-menu">
                    <span class="wait-spin fa fa-spinner fa-spin"></span>
                    <select class="local-menu" ng-options="o.name for o in options" ng-model="selectedOption" ng-change="get_lang(selectedOption.id)"></select>
                </div>
			</div>
			<div class="panel-body">
	            @if( $count_pages > 0 )
                    <a href="#" class="btn btn-flat btn-primary" ng-click="expandAll()">Развернуть все</a>
                    <a href="#" class="btn btn-flat btn-primary" ng-click="collapseAll()">Свернуть  все</a>
                    <script type="text/ng-template" id="nodes_renderer.html">
                        <div class="tree-node">
                            <div class="pull-left tree-handle" ui-tree-handle>
                                <span class="fa fa-bars"></span>
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
                                   href="/master/pages/[[node.type]]/edit/[[node.id]]">[[node.name]]</a>
                                <div class="pull-right">
                                    <a title="Edit" href="/master/pages/[[node.type]]/edit/[[node.id]]"
                                       class="btn btn-success btn-flat">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                    <a href="#" class="delete btn btn-danger btn-flat" ng-if="node.constant !== 1"
                                       data-id="[[node.id]]" ng-click="delete(node)" )><span
                                                class="fa fa-trash-o"></span></a>
                                </div>
                            </div>
                        </div>
                        <ol ui-tree-nodes="" ng-model="node.children"  ng-class="{hidden: collapsed}">
                            <li ng-repeat="node in node.children" ui-tree-node ng-include="'nodes_renderer.html'">
                            </li>
                        </ol>
                    </script>
                    <div ui-tree="dataOptions" data-max-depth="2" id="tree-root">
                        <ol ui-tree-nodes ng-model="data">
                            <li ng-repeat="node in data" ui-tree-node ng-include="'nodes_renderer.html'"></li>
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
@endpush

@push('scripts')
	<script src="{{url('/bower_components/angular/angular.min.js')}}"></script>
	<script src="{{url('/bower_components/angular/angular-ui-tree.min.js')}}"></script>
	<script>
        //angular
        (function() {
            'use strict';

            var app = angular.module('treeApp', ['ui.tree'], function($interpolateProvider) {
                $interpolateProvider.startSymbol('[[');
                $interpolateProvider.endSymbol(']]');
            });

            app.controller('treeCtrl', function($scope, $http) {
                $scope.data = {!!$pages!!}
                $scope.options = {!! $languages !!}
                var lang = "{{Session::get('alang')}}";
                for(var i=0;i<$scope.options.length;i++){
                    if($scope.options[i].id == lang){
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

                $scope.dataOptions = {
                    dropped: function(event) {
                        $http.post('/master/pages/{{$page_type}}', { _token: '{{ Session::token() }}', data: $scope.data, action: 'rebuild' }).
                        success(function(data, status, headers, config) {
                            console.log(data);
                        }).
                        error(function(data, status, headers, config) {
                            console.log('error');
                        });
                    }
                };

                $scope.get_lang = function (lang) {
                    $(".wait-spin").show();
                    $http({
                        method: 'POST',
                        url: "{{route('get-lang-pages')}}",
                        data: {
                            _token: "{{ Session::token() }}",
                            lang: lang,
							page_type:"{{$page_type}}"
                        }
                    }).then(function successCallback(response) {
                        $scope.data = response.data;
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
                    $("button[data-id="+node.id+"]").find('span').addClass('fa-spinner fa-spin');
                    $http({
                        method: 'POST',
                        url: "{{route('pages-delete')}}",
                        data: {
                            _token: "{{ Session::token() }}",
                            checked: checked,
                            page_type:"{{$page_type}}"
                        }
                    }).then(function successCallback(response) {
                        if(response.data['status'] == false){
                            alert(response.data['error']);
                            $("button[data-id="+node.id+"]").find('span').removeClass('fa-spinner fa-spin');
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
                        url: "{{route('pages-delete')}}",
                        data: {
                            _token: "{{ Session::token() }}",
                            checked: checked,
                            page_type:"{{$page_type}}"
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
        $(document).ready(function() {

			/*Проверяет есть ли выделенные checkbox*/
            function check_check() {
                console.log('1');
                var checked = false;
                $('.btn-delete-all').removeClass('disabled');
                $('.tree-node-content input:checkbox').each(function (i,elem) {
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

            // отметим всех детей, если они есть и отметили родителя
            $('.input[name*="check"]').on( 'click', function() {
                if( !$(this).is(':checked') ){
                    $(this).closest("li").find('input[type="checkbox"][name*="check"]').prop('checked', false);
                } else {
                    $(this).closest("li").find('input[type="checkbox"][name*="check"]').prop('checked', true);
                }
                check_check();
            });


            // выделить все
            $("#check_all").on( 'click', function() {
                $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length>0 );
                check_check();
            });

            $('input[type="checkbox"][name*="check"]').on('click',function () {
                check_check();
            });

        })
	</script>
@endpush