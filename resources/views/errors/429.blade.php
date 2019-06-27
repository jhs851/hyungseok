@extends('errors.illustrated-layout')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message', __('Sorry, you are making too many requests to the server.'))
@section('image')
    <div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop