@extends('layouts.main')

@section('title', 'Page Title')

@section('content')

<?php
?>
<div style="width:800px; margin:0 auto;">
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title"style="font-weight: bold;">{{trans('company.name')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->name}}
        </div>
    </div>
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title"style="font-weight: bold;">{{trans('company.address')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->address}}
        </div>
    </div>
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title" style="font-weight: bold;">{{trans('company.bulstat')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->bulstat}}
        </div>
    </div>
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title"style="font-weight: bold;">{{trans('company.note')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->note}}
        </div>
    </div>
    <!--    <div class="panel panel-info" style="margin: 1em;">
            <div class="panel-heading">
                <h3 class="panel-title"style="font-weight: bold;">user</h3>
            </div>
            <div class="panel-body">
                {{$company->user}}
            </div>
        </div>-->
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title"style="font-weight: bold;">{{trans('company.category')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->category}}
        </div>
    </div>
    <div class="panel panel-info" style="margin: 1em;">
        <div class="panel-heading">
            <h3 class="panel-title"style="font-weight: bold;">{{trans('company.date')}}:</h3>
        </div>
        <div class="panel-body">
            {{$company->date_create}}
        </div>
    </div>

    <a href="/company" class="btn btn-primary btn-lg btn-block">{{trans('buttons.back')}}</a>
    <button  id="persons" class="btn btn-default btn-lg btn-block">служители</button>
    <br>
    <table class="table table-bordered table-striped" id="table">

    </table>

    <script>
        //document.getElementById("persons").onclick = function() {
        //    //disable
        //    alert(1);
        //    this.disabled = true;
        //
        //    //do some validation stuff
        //}

        $("#persons").one("click", function () {
            $.ajax({
                type: 'GET',
                url: '/person?id={{$company->id}}',
                dataType: 'json',
                success: function (data) {
                    var table = '<tr><th>id</th><th>name</th><th>email</th><th>company</th><th>position</th><th>EGN</th><th></th></tr>';
                    $.each(data.data, function (index, value) {
                        table += '<tr>';
                        table += '<td>' + value.id + '</td>';
                        table += '<td>' + value.name + '</td>';
                        table += '<td>' + value.email + '</td>';
                        table += '<td>' + value.company + '</td>';

                        table += '<td>' + value.position + '</td>';
                        table += '<td>' + value.EGN + '</td>';
                        table += ' @can("person_edit","App\Models\PersonModel")';
                        table += ' <td><a href="/person/edit/' + value.id + '" class="btn btn-warning"><span class="glyphicon glyphicon-edit"> </span></a></td>';
                        table += ' @endcan';
                        table += '</tr>';

                    });

                    $('#table').append(table);

                }
            });
        });
    </script>
    @endsection