@extends('layouts.main')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome</div>
                <center>
                    @if(Auth::check())
                    <div class="panel-body">
                        <a href="{{route('company')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span>  company</a>
                        <a href="{{route('add')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span> New company</a>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('person')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span>  Persons</a>
                        <a href="{{route('addPerson')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span> New person</a>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('user')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span>  Users</a>
                        <a href="{{route('newUser')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span> New user</a>
                    </div>
                    <div class="panel-body">
                        <a href="{{route('profile')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span>  Profile</a>
                        <a href="{{route('chagePassword')}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span> Chage password</a>
                    </div>

                    @else
                    <div class="panel-body">
                        <a href="{{'/login'}}" class="btn btn-success"><span class="glyphicon glyphicon-ok"> </span>  LOGIN</a>
                    </div>
                    @endif
                </center>
            </div>
        </div>
    </div>
</div>
@endsection
