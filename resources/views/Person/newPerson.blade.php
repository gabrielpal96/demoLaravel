@extends('layouts.main')

@section('title', 'new person')

@section('content')

<?php
$company = \App\Helpers\Helpers::FormCollectiveSelectFormat($company);
$country = \App\Helpers\Helpers::FormCollectiveSelectFormat($country);
$category = \App\Helpers\Helpers::FormCollectiveSelectFormat($category);
?>
{{Form::open(['route' => 'savePerson','method' => 'post']) }}
{!! csrf_field() !!}
<div class="form-group row">
    {{Form::label('name', trans('persons.name'))}}

    {{Form::text('name','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('EGN', trans('persons.EGN'))}}
    {{Form::text('EGN','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('date', "дата на раждане")}}
    {{Form::text('date','',['class'=>"form-control",'id'=>'datepicker'])}}
</div>
<div class="form-group row">
    {{Form::label('email', trans('persons.email'))}}
    {{Form::text('email','',['class'=>"form-control"])}}
</div>
<div class="form-group row">
    {{Form::label('companyid', trans('persons.company'))}}
    {{Form::text('', '',['id'=>'companyid'])}}
    {{Form::hidden('companyid','',['id'=>'companyidHidden'])}}
    <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal" >
        <span class="glyphicon glyphicon-plus" ></span>    
    </button>
</div>
<div class="form-group row">
    {{Form::label('position', trans('persons.position'))}}
    {{Form::select('position', $position)}}
</div>

<div class="form-group row">
    {{Form::label('country', 'Държава')}}
    {{Form::select('country',[null=>'Please Select'] +  $country,['id'=>'country'])}}
</div>
<div class="form-group row">
    {{Form::label('city', 'city')}}
    {{Form::select('city',[null=>'Please Select'] ,['id'=>'city'])}}
</div>

{{Form::submit(trans('buttons.submit'),['class'=>'form-control btn btn-success'])}}
{!! Form::close() !!}
<a href="/person" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
@include('layouts._modal.newCompanyModal')
<script src="/js/datepicker/datepicker-{{session('lang')}}.js"></script>
<script>
$(function (datepicker) {

    $("#companyid").autocomplete({
        source: "/person/getCompany",
        minLength: 1,
        select: function (event, ui) {
            event.preventDefault();
            $('input#companyidHidden').val(ui.item.id);
            $('input#companyid').val(ui.item.label);
            console.log(ui.item);
        }
    });

    $('#country').on("change", function (e) {
        e.preventDefault();
        var countryId = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: 'POST',
            url: '/person/getCity',
            data: {id: countryId, _token: _token},
            success: function (data) {

                $('#city option').remove();

                $.each(data, function (index, value) {
                    $("#city").append($('<option>', {
                        value: value.id,
                        text: value.name
                    }));
                });
            },
        })
    });
    $("#datepicker").datepicker({
        firstDay: 1,
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
        yearRange: "-100:+0",

    });

});
</script>
@endsection

