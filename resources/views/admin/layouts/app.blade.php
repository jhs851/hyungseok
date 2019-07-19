<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="msapplication-tap-highlight" content="no">

        {{-- Chrome, Firefox OS and Opera --}}
        <meta name="theme-color" content="">
        {{-- Windows Phone --}}
        <meta name="msapplication-navbutton-color" content="">
        {{-- iOS Safari --}}
        <meta name="apple-mobile-web-app-status-bar-style" content="">

        {{-- CSRF Token --}}
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Authenticate --}}
        <meta name="auth" content="{{ auth()->check() }}">
        @auth <meta name="user" content="{{ auth()->user() }}"> @endauth

        {{-- Favicon --}}
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

        <title>{{ config('app.name') }}</title>

        {{-- Styles --}}
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">

        @yield('style')
    </head>

    <body>
        <div id="app">
            <main>
                @yield('content')
            </main>
        </div>

        {{-- Scripts --}}
        <script src="{{ asset('js/languages.js') }}"></script>
        <script src="{{ mix('js/app.js') }}"></script>

        {{-- Flassh message --}}
        @include('flash::message')

        @yield('script')
    </body>
</html>