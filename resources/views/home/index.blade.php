@extends('layouts.app')

@section('style')
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            height: calc(100vh - 66px);
        }

        .full-height {
            height: calc(100vh - 66px);
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
                <a href="{{ route('developments.index') }}">
                    @lang('developments.title')
                </a>
            </div>
        </div>
    </div>
@stop
