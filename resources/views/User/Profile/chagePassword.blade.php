@extends('layouts.main')

@section('title', 'chage password')

@section('content')

<?php
//$id = $user->toArray()[0]['id'];
//$avatar = $user->toArray()[0]['avatar'];
?>

<div class="modal-body">
    <div align="center">
        {{Form::open(['route' => 'chagePassword','method' => 'post']) }}
        <div class="form-group row">
            {{Form::label('oldpassword', 'въведи старата парола:')}}
            <br>
            {{Form::password('oldpassword','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('newpassword', 'въведи новата парола:')}}
            <br>
            {{Form::password('newpassword','',['class'=>"form-control"])}}
        </div>
        <div class="form-group row">
            {{Form::label('newpassword2', 'повтори новата парола:')}}
            <br>
            {{Form::password('newpassword2','',['class'=>"form-control"])}}
        </div>
        {{ Form::hidden('id', Auth::user()->id) }}
        {{Form::submit('Запиши!',['class'=>'form-control btn btn-success'])}}
        {!! Form::close() !!}
        <br>
        <br>
        <a href="{{URL::previous() }}" class="btn btn-primary btn-lg btn-block">Back</a>
    </div>
</div>

@endsection

