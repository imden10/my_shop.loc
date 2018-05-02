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
            <li>Пользователи</li>
            <li>
                <a href="/master/users/users-permissions">Группы пользователей</a>
            </li>
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master/users/users-permissions" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
    {!! Form::model($role, ['route'=> ['master.users.users-permissions.update',$role->id], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    {{ method_field('PUT') }}
    <div class="box box-success" style="margin: 0 15px">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', 'Название', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('name',$role->name, array('class'=>'form-control','placeholder'=>'admin') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('display_name', 'Имя для отображения', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('display_name', $role->display_name, array('class'=>'form-control','placeholder'=>'Администратор') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Описание', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('description', $role->description, array('class'=>'form-control','placeholder'=>'Может все') ) !!}
                </div>
            </div>
            <div class="box box-danger" style="margin: 0 15px;">
                <div class="box-header">
                    <h3 class="box-title">Назначте права для группы:</h3>
                    <div class="box-tools">
                        <label>Выделить права:</label>
                        <span class="btn btn-danger set-admin-btn">Админ</span>
                        <span class="btn btn-warning set-manager-btn">Менеджер</span>
                        <span class="btn btn-info set-user-btn">Пользователь</span>
                        <span class="btn btn-default set-empty-btn"><i class="fa fa-eraser"></i> Очистить</span>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding">
                    <table class="table table-hover">
                        <tbody class="tbody">
                        <tr>
                            <th>#</th>
                            <th><input type="checkbox" class="check-all"></th>
                            <th>Название</th>
                            <th>Описание</th>
                        </tr>
                        @foreach($permissions as $key => $item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><input type="checkbox" name="check[]" value="{{$item->id}}"
                                    @if(in_array($item->id,$permissions_role)) checked @endif></td>
                                <td>{{$item->display_name}}</td>
                                <td>{{$item->description}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@stop
@push('styles')

@endpush
@push('scripts')
<script>
    /*Права для группы*/
    var adminPermissions    = [1,2,3,4,5,6,7,8];
    var managerPermissions  = [1,2,5,6];
    var userPermissions     = [1,2];
    var emptyPermissions    = [];
    function setPermissions(permissions){
        $(".tbody input[type='checkbox'][name*='check']").each(function (i) {
            if($.inArray(+$(this).val(),permissions) !=-1){
                $(this).prop('checked',true);
            }
            else {
                $(this).prop('checked',false);
            }
        })
    }
    /*jquery------------------------------------------------*/
    $(document).ready(function() {

        $('.set-admin-btn').on('click',function () {
            setPermissions(adminPermissions);
        });
        $('.set-manager-btn').on('click',function () {
            setPermissions(managerPermissions);
        });
        $('.set-user-btn').on('click',function () {
            setPermissions(userPermissions);
        });
        $('.set-empty-btn').on('click',function () {
            setPermissions(emptyPermissions);
        });
        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        })

        // выделить все
        $(".check-all").on('click', function () {
            $('input[type="checkbox"][name*="check"]').prop('checked', $('input[type="checkbox"][name*="check"]:not(:checked)').length>0 );
            check_check();
        });
    });
</script>
@endpush