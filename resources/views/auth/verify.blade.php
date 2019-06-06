@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('auth.verify.title')</div>

                    <div class="card-body text-center">
                        @if (session('resent'))
                            <div class="alert alert-success text-left" role="alert">
                                @lang('auth.verify.sent')
                            </div>
                        @endif

                        <p class="card-text">
                            @lang('auth.verify.description')
                        </p>

                        <a class="btn btn-primary" href="{{ route('verification.resend') }}" @click="disable($event, '@lang('auth.sending')')">
                            @lang('auth.verify.send')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
