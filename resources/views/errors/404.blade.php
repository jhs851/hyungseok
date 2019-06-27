@extends('errors::illustrated-layout')

@section('code', '404')

@section('title', __('Not Found'))

@section('image')
    <div style="background-image: url('/svg/404.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@endsection

@section('message', __('Sorry, we can\'t find the page you\'re looking for.'))
