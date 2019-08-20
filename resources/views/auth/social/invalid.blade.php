@extends('errors.illustrated-layout')

@section('title', trans('auth.social.invalid'))
@section('code', '422')
@section('message')
    @lang('auth.social.reasons_of_invalid')

    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
@stop
@section('button')
    <a href="{{ route('login') }}">
        <button class="bg-transparent text-grey-darkest font-bold uppercase tracking-wide py-3 px-6 border-2 border-grey-light hover:border-grey rounded-lg">
            @lang('auth.login')
        </button>
    </a>
@stop
@section('image')
    <div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center"></div>
@stop
