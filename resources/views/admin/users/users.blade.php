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
            <a href="/master/users/users/create" class="btn btn-success" title="Добавить" data-toggle="tooltip" data-placement="left">
                <i class="fa fa-plus"></i>
            </a>
            <a class="btn btn-warning check-all" title="Выделить все" data-toggle="tooltip">
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
	<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-users"></i>
				<span class="page-name">{{$title}}</span>&nbsp;|&nbsp;
				<span class="label label-success" style="margin-left: 0!important;">Всего {{count($items)}} {{ Lang::choice('пользователь|пользователя|пользователей', count($items) , array(), 'ru') }}</span>
                <input type="text" class="top-search-input" placeholder="Быстрый поиск">
			</div>
			<div class="panel-body">
	            @if( count($items) > 0 )
                    <table class="table table-bordered table-hover table_users">
                        <thead>
                        <tr style="color:#337ab7">
                            <th style="width: 50px; text-align: center">
                                <input type="checkbox" value="" class="check-all">
                            </th>
                            <th style="width: 100px;">Фото</th>
                            <th style="width: 300px;">Имя</th>
                            <th style="width: 300px;">E-mail</th>
                            <th style="width: 300px;">Группа</th>
                            <th style="text-align: right; min-width: 110px">Действие</th>
                        </tr>
                        </thead>
                        <tbody class="table-body">
                        @foreach($items as $item)
                            <tr data-id="{{ $item->id }}" @if(Auth::user()->id == $item->id) style="background-color: #eee" @endif>
                                <td style="text-align: center; vertical-align: middle;">
                                    @if(Auth::user()->id != $item->id)
                                        <input type="checkbox" name="check[]" value="{{ $item->id }}">
                                    @endif
                                </td>
                                <td style="vertical-align: middle;">
                                    <a href="/uploads/users/{{$item->photo}}">
                                        <img src="/uploads/users/{{$item->photo}}" class="thumbnail" style="width: 60px" alt="user photo">
                                    </a>
                                </td>
                                <td class="selector-name" style="vertical-align: middle;">
                                    <a href="/master/users/users/{{$item->id}}/edit">
                                        {{$item->name}}
                                    </a>
                                </td>
                                <td style="vertical-align: middle;">
                                    {{$item->email}}
                                </td>
                                <td style="vertical-align: middle;">
                                    <span class="label label-success">
                                        {{$item->role_name}}
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <div style="margin-right: 10px">
                                        <a href="/master/users/users/{{$item->id}}/edit" type="button" class="btn btn-success btn_edit_user" title="Изменить"
                                           data-toggle="tooltip">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        @if(Auth::user()->id != $item->id)
                                            <button type="button" class="btn btn-danger delete-btn-one" data-id="{{ $item->id }}" title="Удалить"
                                                    data-toggle="tooltip">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        @endif
                                    </div>
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

@endpush

@push('scripts')
<script src="{{url('admin/js/jquery.quick-search.js')}}"></script>
<script>
    // jquery
    $(document).ready(function () {

        /*Быстрый поиск*/
        $('.top-search-input').quicksearch('table tbody tr', {
            selector: '.selector-name'
        });
        /*Проверяет есть ли выделенные checkbox*/
        function check_check() {
            var checked = false;
            $('.btn-delete-all').removeClass('disabled');
            $('.table-body input:checkbox').each(function (i, elem) {
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
        $(".check-all").on('click', function () {
            $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length>0 );
            check_check();
        });

        $("input[type='checkbox'][name*='check']").on('click',function () {
            check_check();
        });

        /*Удаляем один элемент*/
        $(".delete-btn-one").on('click', function () {
            var id = $(this).data('id');
            $(this).find('i').addClass('fa-spinner fa-spin');
            $.ajax({
                url: 'users/destroy',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    _method:"DELETE",
                    checked:[id]
                },
                success: function(json){
                    if (json.status){
                        for (var i=0;i<json.checked.length; i++){
                            $(".table-body tr[data-id="+json.checked[i]+"]").fadeOut();
                        }
                    }
                }
            });
        });

        /*Удаляем выделенные элементы*/
        $(".btn-delete-all").on('click', function () {
            var checked = [];
            $('.table-body input:checkbox').each(function (i,elem) {
                if ($(this).prop('checked')){
                    checked.push($(this).val());
                }
            });
            $(this).find('i').addClass('fa-spinner fa-spin');
            $.ajax({
                url: 'users/destroy',
                type: 'post',
                dataType: 'json',
                data: {
                    _token: "{{csrf_token()}}",
                    _method:"DELETE",
                    checked:checked
                },
                success: function(json){
                    console.log(json);
                    if (json.status){
                        for (var i=0;i<json.checked.length; i++){
                            $(".table-body tr[data-id="+json.checked[i]+"]").fadeOut();
                        }
                        $('.btn-delete-all').find('i').removeClass('fa-spinner fa-spin');
                    }
                }
            });
        });

    })
</script>
@endpush