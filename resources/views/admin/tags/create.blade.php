@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row justify-content-center">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">@lang('admin.tags.create')</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.tags.store') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">@lang('validation.attributes.tags')</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $tag->name) }}" required autocomplete="name">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        @lang('admin.tags.create')
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
