@extends('layouts.app', ['writing' => true])

@section('content')
    <create-development-view ref="form" inline-template>
        <div>
            <markdown-helper></markdown-helper>

            <div class="container py-5">
                <div class="row">
                    <div class="col-12 p-3 p-md-6 bg-white shadow">
                        <form method="POST" action="{{ route('developments.store') }}">
                            @csrf

                            <div class="form-group">
                                <input type="text" class="border-0 h2 w-100" name="title" value="{{ old('title') }}"
                                       placeholder="@lang('validation.attributes.title')" required autocomplete="title"
                                       autofocus>
                            </div>

                            <hr class="mb-5">

                            <div class="form-group">
                                <markdown-editor name="body" value="{{ old('body') }}" @uploaded="addPath"></markdown-editor>
                            </div>

                            <div class="form-group">
                                <tags-select :old="{{ json_encode(old('tags', [])) }}"></tags-select>
                            </div>

                            <div v-if="uploadedImagesPath.length" class="form-group border px-3 py-2 mb-0">
                                <p class="text-black-50 mb-2">@lang('developments.uploaded_images')</p>

                                <ul class="list-unstyled mb-0">
                                    <li v-for="path in uploadedImagesPath">
                                        <div class="input-group my-1">
                                            <input type="text" :value="path" class="form-control" readonly>

                                            <div class="input-group-append">
                                                <clipboard class="input-group-text" :data="path">
                                                    <i class="far fa-copy"></i>
                                                </clipboard>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </create-development-view>
@stop

@section('script')
    <script>
        @foreach ($errors->all() as $message)
            toastr.error('{{ $message }}');
        @endforeach
    </script>
@stop
