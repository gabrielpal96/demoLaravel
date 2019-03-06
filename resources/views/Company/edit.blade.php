@extends('layouts.main')

@section('title', 'Page Title')

@section('content')

<?php
$category = \App\Helpers\Helpers::FormCollectiveSelectFormat($category);
?>

{{Form::open(['route' => 'update','method' => 'post']) }}
<div class="form-group row">
    {{Form::label('name', trans('company.name'))}}

    {{Form::text('name',$company->name,['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('address', trans('company.address'))}}
    {{Form::text('address',$company->address,['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('bulstat', trans('company.bustat'))}}
    {{Form::text('bulstat',$company->bulstat,['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('note', trans('company.note'))}}
    {{Form::text('note',$company->note,['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('category', trans('company.category'))}}
    {{Form::select('category', $category,$company->categoryid)}}
</div>
{{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
{{ Form::hidden('id', $company->id) }}
{!! Form::close() !!}
<a href="/person" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
@endsection

