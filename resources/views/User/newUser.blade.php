@extends('layouts.main')

@section('title', 'new user')

@section('content')

<?php
$role = \App\Helpers\Helpers::FormCollectiveSelectFormat($role);
?>

<div class="modal-body">
    <div align="center">
        {{Form::open(['route' => 'saveUser','method' => 'post']) }}
        <div class="form-group row">
            {{Form::label('username', trans('users.username'))}}

            {{Form::text('username','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('email', trans('users.email'))}}

            {{Form::text('email','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('password', trans('users.password'))}}
            <br>
            {{Form::password('password','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('password2', trans('users.rePassword'))}}
            <br>
            {{Form::password('password2','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('Role', trans('users.role'))}}
            <br>
            {{Form::select('role_id', $role)}}
        </div>
        {{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
        {!! Form::close() !!}

        <br>
        <br>
        <a href="/user" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
    </div>
</div>


@endsection

