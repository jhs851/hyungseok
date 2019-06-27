@extends('errors::illustrated-layout')

@section('code', '503')

@section('title', __('Service Unavailable'))

@section('image')
    <div style="background-image: url('/svg/503.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@endsection

@section('message', __($exception->getMessage() ?: 'Sorry. We\'re in maintenance. We\'ll be back soon with a better service.'))
