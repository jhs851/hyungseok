@extends('layouts.app')

@section('content')
    <div class="container py-7">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">@lang('auth.passwords.reset')</div>

                    <password-request class="card-body"></password-request>
                </div>
            </div>
        </div>
    </div>
@endsection
