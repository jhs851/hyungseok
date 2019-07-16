@extends('layouts.app', ['writing' => true])

@section('content')
    <markdown-helper></markdown-helper>

    <div class="container py-5">
        <div class="row">
            <div class="col-12 p-3 p-md-6 bg-white shadow">
                <form ref="form" method="POST" action="{{ route('developments.store') }}">
                    @csrf

                    <div class="form-group">
                        <input type="text" class="border-0 h2 w-100" name="title" value="{{ old('title') }}"
                               placeholder="@lang('validation.attributes.title')" required autocomplete="title"
                               autofocus>
                    </div>

                    <hr class="mb-5">

                    <div class="form-group mb">
                        <markdown-editor name="body" value="{{ old('body') }}"></markdown-editor>
                    </div>

                    <div class="form-group mb-0">
                        <tags-select :old="{{ json_encode(old('tags', [])) }}"></tags-select>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        @foreach ($errors->all() as $message)
            toastr.error('{{ $message }}');
        @endforeach
    </script>
@stop
