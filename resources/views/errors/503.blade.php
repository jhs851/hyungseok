@extends('errors.illustrated-layout')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Sorry. We\'re in maintenance. We\'ll be back soon with a better service.'))
@section('image')
    <div style="background-image: url('/svg/503.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop