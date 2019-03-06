@extends('layouts.main')

@section('title', 'new company')

@section('content')

<?php

$category = \App\Helpers\Helpers::FormCollectiveSelectFormat($category)
?>
{{Form::open(['route' => 'save','method' => 'post']) }}
<div class="form-group row">
    {{Form::label('name', trans('company.name'))}}

    {{Form::text('name','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('address', trans('company.address'))}}
    {{Form::text('address','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('bulstat', trans('company.bulstat'))}}
    {{Form::text('bulstat','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('note', trans('company.note'))}}
    {{Form::text('note','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('category', trans('company.category'))}}
    {{Form::select('category', $category)}}
</div>
{{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
{!! Form::close() !!}
<a href="/company" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
@endsection

