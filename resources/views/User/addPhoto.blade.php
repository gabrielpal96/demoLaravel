@extends('layouts.main')

@section('title', 'user photo')

@section('content')

<?php
//$id = $user->toArray()[0]['id'];
//$avatar = $user->toArray()[0]['avatar'];
?>

<div align="center">
    @if($user->toArray()[0]['avatar']==null)
    {{Form::open(['route' => 'upload','method' => 'post', 'files' => true]) }}
    <div class="form-group row">
        {{Form::label('name', trans('users.photo').':')}}

        {{Form::file('image')}}
    </div>
    {{ Form::hidden('id', $id) }}
    {{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
    {!! Form::close() !!}
    @else
    <img src="/upload/user/{{$id}}/{{$user->toArray()[0]['avatar']}}" alt="user photo" width="300" height="250">
    <br><br>
    <a href="{{route('photoDelete',['id'=>$user->toArray()[0]['id']])}}" class="btn btn-primary btn-lg btn-success">
        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
        {{trans('buttons.deletePhoto')}}
    </a>
    @endif

    <br>
    <br>
    <a  href="{{URL::previous() }}" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
</div>


@endsection

