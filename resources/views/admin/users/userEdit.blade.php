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
            <li>
                <a href="/master/users/users">Пользователи</a>
            </li>
            <li class="active">{{$title}}</li>
        </ol>
        <div class="btns-panel">
            <a href="#" onClick="event.preventDefault();$('.form-horizontal').submit()" class="btn btn-success" title="Сохранить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-save"></i>
            </a>
            <a href="/master/users/users" class="btn btn-default" title="Отменить" data-toggle="tooltip" data-placement="bottom">
                <i class="fa fa-reply"></i>
            </a>
        </div>
    </section>

    @include('errors.form-errors')
    {!! Form::model($user, ['route'=> ['master.users.users.update',$user->id], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    {{ method_field('PUT') }}
    <div class="box box-success" style="margin: 0 15px">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', 'Имя', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', $user->name, array('class'=>'form-control') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('photo', 'Фото', array('class'=>'col-sm-2 control-label', 'files' => true ) ) !!}
                <div class="col-sm-10">
                    {!! Form::file('photo',  array('class' => 'filestyle', 'data-value'=>$user->photo, 'data-buttonText' => 'Выберите файл', 'data-buttonName' => 'btn-primary', 'data-icon' => 'false') ) !!}
                    <span style="color: grey;">Рекомендованные размеры: ширина - 200px, высота - 200px</span>
                    <img src="/uploads/users/{{$user->photo}}" class="thumbnail" style="width: 100px" alt="user photo">
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('role', 'Группа пользователей', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    <select name="role" id="role" class="form-control select2" style="width: 100%">
                        @foreach($roles as $role)
                            <option value="{{$role->id}}" @if($user->role == $role->id) selected @endif>{{$role->display_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('email', 'E-mail', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('email', $user->email, array('class'=>'form-control','disabled') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('password', 'Ваш пароль', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('password_confirmation', 'Новый пароль', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}

@stop
@push('styles')
<link rel="stylesheet" href="{{url('bower_components/select2/dist/css/select2.min.css')}}">
@endpush
@push('scripts')
<script src="{{url('/admin/js/bootstrap.filestyle.js')}}"></script>
<script src="{{url('bower_components/select2/dist/js/select2.js')}}"></script>
<script>
    /*jquery------------------------------------------------*/
    $(document).ready(function() {

        /*Инициализация select*/
        $('.select2').select2();

        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        })

    });
</script>
@endpush