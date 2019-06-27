@extends('errors.illustrated-layout')

@section('title', __('Server Error'))
@section('code', '500')
@section('message', __('Whoops, something\'s wrong with our server.'))
@section('image')
    <div style="background-image: url('/svg/500.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop