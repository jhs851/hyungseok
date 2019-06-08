@extends('layouts.app', ['writing' => true])

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-10 offset-md-1 p-3 p-md-6 bg-white shadow">
                <form ref="form" method="POST" action="{{ route('developments.store') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="border-0 h2" name="title" value="{{ old('title') }}" placeholder="@lang('validation.attributes.title')" required autocomplete="title" autofocus>
                    </div>

                    <hr class="mb-5">

                    <div class="form-group">
                        <textarea class="border-0 w-100" name="body" placeholder="@lang('developments.body_placeholder')" required rows="30">{{ old('body') }}</textarea>
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
