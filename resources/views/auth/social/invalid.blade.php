@extends('errors.illustrated-layout')

@section('title', trans('auth.social.invalid'))
@section('code', '422')
@section('message')
    다음 유효성 검사 실패로 소셜 로그인에 실패했습니다.<br>
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
