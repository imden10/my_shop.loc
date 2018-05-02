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
            <a class="btn btn-warning" id="check_all" title="Выделить все" data-toggle="tooltip">
                <i class="fa fa-check"></i>
            </a>
            <a href="#" class="btn btn-danger disabled btn-delete-all" title="Удалить выбранные" data-toggle="tooltip" data-placement="bottom">
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
            <h3 class="box-title">Добавить новый язык</h3>
            <div class="box-tools pull-right">
                <button type="button" onfocus="this.blur();" class="btn btn-box-tool collapse-toggle-btn"><i class="fa fa-plus"></i></button>
            </div>
        </div>
        <form class="form-horizontal" action="languages/create" method="post">
            {!! csrf_field() !!}
            <div class="box-body">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Название</label>
                    <div class="col-sm-10">
                        <input type="text" style="width: 200px;" class="form-control" id="name" name="name">
                    </div>
                </div>
                <div class="form-group">
                    <label for="lang" class="col-sm-2 control-label">Код</label>
                    <div class="col-sm-10">
                        <select name="lang" class="my_select">
                            @foreach(config('laravellocalization.supportedLocales') as $key => $lang)
                                <option value="{{$key}}">{{$lang['name']}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-success pull-right">Добавить</button>
            </div>
        </form>
    </div>

	<div class="container-fluid" ng-app="treeApp">
		<div class="panel panel-default" ng-controller="treeCtrl">
			<div class="panel-heading">
				<i class="fa fa-globe"></i>
				<span class="page-name">Языки</span>&nbsp;|&nbsp;
				<span class="label label-success" style="margin-left: 0!important;">Всего {{count($items)}} {{ Lang::choice('язык|языка|языков', count($items) , array(), 'ru') }}</span>
			</div>
			<div class="panel-body">
	            @if( count($items) > 0 )
                    <table class="table table_body">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="check-all"></th>
                            <th>Название</th>
                            <th>Код</th>
                            <th style="text-align: right; width: 200px">Управление</th>
                        </tr>
                        </thead>
                        <tbody class="tree-node-content">
                        @foreach($items as $item)
                            <tr data-id="{{$item->id}}">
                                <td>
                                    @if($item->default == 0)
                                        <input type="checkbox" name="check[]" class="check-one" value="{{$item->id}}">
                                    @endif
                                </td>
                                <td>
                                    <input type="text" class="form-control name edit" value="{{$item->name}}">
                                </td>
                                <td>
                                    <h3 style="margin: 0">
                                        <span class="label label-success">{{$item->lang}}</span>
                                    </h3>
                                </td>
                                <td style="text-align: right">
                                    @if($item->default == 0)
                                    <span class="btn btn-info rep-btn" style="display: none" title="Обновить" data-toggle="tooltip"
                                          data-id="{{$item->id}}">
                                        <i class="fa fa-refresh"></i>
                                    </span>
                                    <span class="btn btn-danger delete-btn-one" title="Удалить" data-toggle="tooltip"
                                          data-id="{{$item->id}}">
                                        <i class="fa fa-minus"></i>
                                    </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="alert alert-warning" role="alert">
                        Нет записей
                    </div>
                @endif
			</div>
		</div>
	</div>


@endsection

@push('styles')
<link href="{{url('/plagins/jquery.sumoselect-master/sumoselect.css')}}" rel="stylesheet"/>
@endpush

@push('scripts')
<script src="{{url('/plagins/jquery.sumoselect-master/jquery.sumoselect.min.js')}}"></script>
<script>
    // jquery
    $(document).ready(function () {

        /*Инициализация мульти селекта sumoselect*/
        $('.my_select').SumoSelect();

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

        // отметим всех детей, если они есть и отметили родителя
        $('.check-one').on('click', function () {
            if (!$(this).is(':checked')) {
                $(this).closest("li").find('input[type="checkbox"][name*="check"]').prop('checked', false);
            } else {
                $(this).closest("li").find('input[type="checkbox"][name*="check"]').prop('checked', true);
            }
            check_check();
        });


        // выделить все
        $("#check_all, .check-all").on('click', function () {
            $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length > 0);
            check_check();
        });

        /*Событие на елемент name*/
        $('.edit').on('keyup',function () {
            var id = $(this).parent('td').parent('tr').data('id');
            $(".btn-info[data-id="+id+"]").fadeIn();
        });

        /*Удаляем один элемент*/
        $(".delete-btn-one").on('click', function () {
            var id = $(this).data('id');
            $(this).find('i').addClass('fa-spinner fa-spin');
            $.ajax({
                url: 'languages/destroy',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    check:[id]
                },
                success: function(json){
                    if (json.status){
                        for (i=0;i<json.checked.length; i++){
                            $(".table_body tr[data-id="+json.checked[i]+"]").fadeOut();
                        }
                    }
                }
            });
        });

        /*Удаляем выделенные элементы*/
        $(".btn-delete-all").on('click', function () {
            var checked = [];
            $('.table_body input:checkbox').each(function (i,elem) {
                if ($(this).prop('checked')){
                    checked.push($(this).val());
                }
            });
            $(this).find('i').addClass('fa-spinner fa-spin');
            $.ajax({
                url: 'languages/destroy',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    check:checked
                },
                success: function(json){
                    console.log(json);
                    if (json.status){
                        for (i=0;i<json.checked.length; i++){
                            $(".table_body tr[data-id="+json.checked[i]+"]").fadeOut();
                        }
                        $('.btn-delete-all').find('i').removeClass('fa-spinner fa-spin');
                    }
                }
            });
        });

        /*Обновить данные ajax*/
        $('.table_body').on('click','.rep-btn',function () {
            $(this).find('i').addClass('fa-spinner fa-spin');
            var id = $(this).data('id');
            $.ajax({
                url: 'languages/update',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    id:id,
                    name:$("tr[data-id="+id+"]").find('.name').val(),
                    lang:$("tr[data-id="+id+"]").find('.lang').val()
                },
                success: function(json){
                    if (json.status){
                        $(".rep-btn[data-id="+json.id+"]").find('i').removeClass('fa-spinner fa-spin').parent().fadeOut();
                    }
                }
            });
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

    })
</script>
@endpush