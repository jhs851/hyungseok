@extends('errors.illustrated-layout')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Sorry, your session has expired. Please refresh and try again.'))
@section('image')
    <div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop
