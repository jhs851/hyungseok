@extends('layouts.app')

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

        .links a {
            color: #636b6f;
            padding: 0 25px;
            text-decoration: none;
        }
    </style>
@stop

@section('content')
    <div class="d-flex align-items-center justify-content-center full-height">
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
