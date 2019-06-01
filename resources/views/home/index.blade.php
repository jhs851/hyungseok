@extends('layouts.app', ['withoutNavigation' => true])

@section('style')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            height: 100vh;
        }

        .full-height {
            height: 100vh;
        }

        .wrap {
            padding-top: 0 !important;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .links a {
            color: #636b6f;
            padding: 0 25px;
            text-decoration: none;
        }
    </style>
@stop

@section('content')
    <div class="d-flex align-items-center justify-content-center full-height">
        @if (Route::has('login'))
            <div class="top-right links">
                @auth
                    <div class="dropdown">
                        <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                @lang('auth.logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}">@lang('auth.login')</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">@lang('auth.register')</a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="text-center">
            <div class="title mb-5">
                <img class="img-fluid" src="{{ asset('images/etc/logo.png') }}" alt="">
            </div>

            <div class="links">
                <a href="{{ route('developments.index') }}">Development post</a>
            </div>
        </div>
    </div>
@stop
