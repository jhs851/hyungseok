@extends('errors.illustrated-layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Sorry, you do not have permission to access this page.'))
@section('image')
    <div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop
