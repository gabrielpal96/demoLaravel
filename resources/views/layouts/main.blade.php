<?php

use Illuminate\Support\Facades\Session;

//
//echo"<pre>";
//print_r(Lang::getLocale());
//echo"</pre>";
?>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Latest compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">-->

    <!-- Optional theme -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>-->
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <title>@yield('title')</title>
    <link rel="shortcut icon"
          href="data:image/png;base64,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"/>
</head>
<body>
{!! csrf_field() !!}
<nav class="navbar navbar-default">

    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>

    </div>


    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">

            @if(Auth::check())
                <li>
                    <a href="/company/">{{trans('nav.companies')}}</a>
                </li>

                <li>
                    <a href="/person/">{{trans('nav.persons')}}</a>
                </li>
                @can('user',App\Models\User::class)
                    <li>
                        <a href="/user">{{trans('nav.users')}}</a>
                    </li>
                @endcan
                @if(Request()->route()->getPrefix()=='/company')
                    <li>
                        <a href="{{route('add')}}">{{trans('nav.newCompany')}}</a>
                    </li>
                @endif
                @if(Request()->route()->getPrefix()=='/person')
                    @can('person_add',App\Models\PersonModel::class)
                        <li>
                            <a href="{{route('addPerson')}}">{{trans('nav.newPerson')}}</a>
                        </li>
                    @endcan
                @endif
                @if(Request()->route()->getPrefix()=='/user')
                    @can('user',App\Models\User::class)
                        <li>
                            <a href="{{route('newUser')}}">{{trans('nav.newUser')}}</a>
                        </li>
                    @endcan
                @endif

            <!-- Authentication Links -->
                @if (!Auth::guest())
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{trans('nav.hi')}},
                            {{ Auth::user()->username }} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('profile')}}">{{trans('nav.profile')}}</a></li>
                            <li><a href="{{route('chagePassword')}}">{{trans('nav.changePassword')}}</a></li>
                        </ul>
                    </li>

                    @if(Auth::user()->avatar!=null)
                        <li>
                            <a href="/user/profile"><img src="/upload/user/{{Auth::user()->id}}/{{Auth::user()->avatar}}" alt=""
                                            height="40" width="40" style="  border-radius: 50%;"></a>
                        </li>
                    @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li>
                <a href="{{ url('/logout') }}"
                   onclick="return  confirm('Сигурни ли сте, че искате да излезете от профила си?')">
                    {{trans('nav.logout')}}
                </a>
            </li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">  {{trans('nav.languages')}}<b
                            class="caret"></b></a>
                <ul class="dropdown-menu">
                    @foreach($lang as $l)
                        @if(Lang::getLocale()!=$l->name)
                            <li>
                                <a href="{{route('languages',['lang'=>$l->name])}}">
                                    <img height="20" width="20" src="/flag/{{$l->flag}}" alt="">
                                    {{$l->name}}</a>
                            </li>
                        @endif

                    @endforeach
                </ul>
            </li>


            @endif
            @endif
        </ul>


    </div>

</nav>
@if (count($errors) > 0)
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div id="test">
    @if(Session::has('message'))
        <div id="Message">
            <div class="alert {{ Session::get('alert-class', 'alert-info') }} fade-message" style=" text-align: center;"
                 id="MessageText">{{ Session::get('message') }}</div>
        </div>
    @endif
</div>
<!--        @section('sidebar')
    This is the master sidebar.
@show-->

    <div class="container">

        @yield('content')
    </div>
    <br>
    <!--<a href="/" class="btn btn-warning btn-lg btn-block">home</a>-->
    <script>
        $(function () {
            // setTimeout() function will be fired after page is loaded
            // it will wait for 5 sec. and then will fire
            // $("#successMessage").hide() function
            setTimeout(function () {
                $("#Message").hide('blind', {}, 800)
            }, 2000);
        });
        //            $(function () {
        //                $("#dialog").dialog();
        //            });
    </script>
    <script src="/js/myJS/Message.js"></script>

</body>
</html>
