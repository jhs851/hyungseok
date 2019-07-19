@extends('admin.layouts.app')

@section('style')
    <style>
        main {
            position: relative;
            background-color: black;
            height: 100vh;
            min-height: 25rem;
            width: 100%;
            overflow: hidden;
        }

        main video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 100%;
            min-height: 100%;
            width: auto;
            height: auto;
            z-index: 0;
            -ms-transform: translateX(-50%) translateY(-50%);
            -moz-transform: translateX(-50%) translateY(-50%);
            -webkit-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        main .container {
            position: relative;
            z-index: 2;
        }

        main .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background-color: black;
            opacity: 0.5;
            z-index: 1;
        }

        main h1 {
            letter-spacing: -.05em;
        }

        main p {
            -ms-word-break: keep-all;
            word-break: keep-all;
        }

        @media (pointer: coarse) and (hover: none) {
            main {
                background: url('{{ asset('images/backgrounds/admin.jpg') }}') black no-repeat center center scroll;
            }
            main video {
                display: none;
            }
        }
    </style>
@stop

@section('content')
    <div class="overlay"></div>
    <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
        <source src="{{ Storage::url('videos/backgrounds/admin.mp4') }}" type="video/mp4">
    </video>

    <div class="container h-100">
        <div class="d-flex h-100 text-center align-items-center">
            <div class="w-100 text-white">
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <h1 class="display-4 font-weight-bold wow fadeInUp">{{ config('app.name') }}</h1>
                        <p class="lead mb-3 wow fadeInUp" data-wow-delay=".2s">
                            @lang('admin.letter_to_me')
                        </p>
                    </div>
                </div>

                <form method="POST" action="" class="text-left fadeInUp">
                    @csrf

                    <div class="form-group row wow fadeInUp" data-wow-delay=".4s">
                        <label for="email" class="col-md-4 col-form-label text-md-right">@lang('validation.attributes.email')</label>

                        <div class="col-md-4">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row wow fadeInUp" data-wow-delay=".6s">
                        <label for="password" class="col-md-4 col-form-label text-md-right">@lang('validation.attributes.password')</label>

                        <div class="col-md-4">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0 wow fadeInUp" data-wow-delay=".8s">
                        <div class="col-md-4 offset-md-4 text-right">
                            <button type="submit" class="btn btn-primary btn-lg">
                                @lang('auth.login')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop