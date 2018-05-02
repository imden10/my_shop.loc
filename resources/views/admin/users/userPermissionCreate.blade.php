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
    {!! Form::model($item, ['route'=> ['master.users.users-permissions.store'], 'class' => 'form-horizontal', 'role' => 'form', 'files' => true ] ) !!}
    {!! csrf_field() !!}
    <div class="box box-success" style="margin: 0 15px">
        <div class="box-header">
            <h3 class="box-title">{{$title}}</h3>
        </div>
        <div class="box-body">
            <div class="form-group">
                {!! Form::label('name', 'Название', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('name', '', array('class'=>'form-control','placeholder'=>'admin') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('display_name', 'Имя для отображения', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('display_name', '', array('class'=>'form-control','placeholder'=>'Администратор') ) !!}
                </div>
            </div>

            <div class="form-group">
                {!! Form::label('description', 'Описание', array('class'=>'col-sm-2 control-label') ) !!}
                <div class="col-sm-10">
                    {!! Form::text('description', '', array('class'=>'form-control','placeholder'=>'Может все') ) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

@stop
@push('styles')

@endpush
@push('scripts')
<script>
    /*jquery------------------------------------------------*/
    $(document).ready(function() {

        /*Сохранить страницу*/
        $('.save_btn').on('click',function (e) {
            e.preventDefault();
            $('form').submit();
        })

    });
</script>
@endpush