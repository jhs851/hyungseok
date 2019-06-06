@extends('layouts.app')

@section('style')
    <style>
        html, body, .wrap, .container, .row {
            height: 100%;
        }

        body {
            background-color: #f9f9f9;
        }

        #navigaiton {
            background-color: white;
            border-bottom: 1px solid #dee2e6;
        }
    </style>
@stop

@section('nav-right')
    <li class="nav-item">
        <a class="nav-link">
            <button class="btn btn-primary" @click.prevent="submit('developments-form')">
                @lang('developments.submit') <i class="fas fa-file-alt ml-2"></i>
            </button>
        </a>
    </li>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div id="editor-wrapper" class="col-md-10 offset-md-1 p-3 p-md-6 bg-white border border-top-0">
                <form ref="developments-form" method="POST" action="{{ route('developments.store') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="border-0 h2" name="title" value="{{ old('title') }}" placeholder="@lang('validation.attributes.title')" required autocomplete="title" autofocus>
                    </div>

                    <hr class="mb-5">

                    <div class="form-group">
                        <textarea class="border-0 w-100" name="body" placeholder="@lang('developments.body_placeholder')" required>{{ old('body') }}</textarea>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    @if ($errors->all())
        <script>toastr.error('@lang('developments.invalid')')</script>
    @endif
@stop
