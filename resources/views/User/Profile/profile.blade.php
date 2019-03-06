@extends('layouts.main')
@section('title', 'profile')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Profile</div>
                <center> 
                    <div class="panel-body">
                        <p > <b>{{trans('users.username')}}:</b> {{Auth::user()->username}}</p>


                        <p > <b>{{trans('users.email')}}:</b>  <span id="email">{{Auth::user()->email}}</span>    
                            <button type="button" class="btn " data-toggle="modal" data-target="#exampleModal" data-email="{{Auth::user()->email}}" data-id="{{Auth::user()->id}}">
                                <span class="glyphicon glyphicon-pencil" ></span>    
                            </button>
                        </p>
                        @if(Auth::user()->avatar!=null)

                        <a href="{{route('addPhoto',['id'=>Auth::user()->id])}}" >
                            <p ><img src="/upload/user/{{Auth::user()->id}}/{{Auth::user()->avatar}}" alt="" height="60" width="60"> </p >
                        </a>
                        @else
                        <a href="{{route('addPhoto',['id'=>Auth::user()->id])}}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-edit"> </span> {{trans('users.addPhoto')}}</a>
                        @endif
                    </div>
                    <div class="panel-body">
                        <a href="{{route('chagePassword')}}" class="btn btn-success"><span class="glyphicon glyphicon-pencil"> </span>  Смяна на парола</a>
                    </div>
                </center>
            </div>
        </div>
    </div>
</div>
<!--bootstrap modal form edit email-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit email</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="tagForm">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Email:</label>
                        <input type="text" class="form-control" id="recipient-name" name="email">
                    </div>
                    <input type="hidden"  name="id" id="recipient-id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                        <button type="submit" id="myFormSubmitButton" class="btn btn-primary">Запиши</button>
                    </div>
            </div>
            </form>
        </div>

    </div>
</div>
<script src="\js\myJS\changeEmailModal.js"></script>
@endsection