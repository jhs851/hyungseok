<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @isset ($fullHeight) class="full-height" @endisset>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="msapplication-tap-highlight" content="no">

    {{-- Search Console --}}
    <meta name="google-site-verification" content="" />
    <meta name="naver-site-verification" content=""/>

    {{-- Chrome, Firefox OS and Opera --}}
    <meta name="theme-color" content="">
    {{-- Windows Phone --}}
    <meta name="msapplication-navbutton-color" content="">
    {{-- iOS Safari --}}
    <meta name="apple-mobile-web-app-status-bar-style" content="">

    {{-- SEO --}}
    <meta name="description" content="{{ config('app.description') }}">

    {{-- Facebook Meta --}}
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:image" content="">
    <meta property="og:type" content="Website">
    <meta property="og:author" content="{{ config('app.name') }}">
    <meta property="og:url" content="{{ config('project.url') }}">
    <meta property="og:description" content="{{ config('app.description') }}">

    {{-- Google Meta --}}
    <meta itemprop="name" content="{{ config('app.name') }}">
    <meta itemprop="description" content="{{ config('app.description') }}">
    <meta itemprop="image" content="">
    <meta itemprop="author" content="{{ config('app.name') }}">

    {{--  Twitter Meta --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ config('app.name') }}">
    <meta name="twitter:description" content="{{ config('app.description') }}">
    <meta name="twitter:image" content="">
    <meta name="twitter:domain" content="{{ config('project.url') }}">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <title>{{ config('app.name') }}</title>

    {{-- Styles --}}
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    @yield('style')
</head>

<body>
    <main id="app" class="wrap">
        @include('layouts.partials.navigation')

        @yield('content')
    </main>

    @include('layouts.partials.footer')

    {{-- Scripts --}}
    <script src="{{ asset('js/languages.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
    {{-- Flassh message --}}
    @include('flash::message')

    @yield('script')
</body>
</html>
