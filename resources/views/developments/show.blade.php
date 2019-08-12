@extends('layouts.app')

@section('style')
    <style>
        #navigation {
            position: fixed;
            top: 0;
            right: 0;
            left: 0;
            z-index: 1030;
            background-color: #fff !important;
            border-bottom: 1px solid #dee2e6 !important;
        }
    </style>
@stop

@section('content')
    <development ref="form" inline-template v-cloak :data="{{ $development }}">
        <div class="container pt-5">
            <div class="row py-5">
                <div class="col-12 p-3 p-md-5 bg-white shadow d-flex flex-column" style="min-height: 800px;">
                    <template v-if="editing">
                        <markdown-helper></markdown-helper>

                        <div class="form-group">
                            <input type="text" ref="title" class="border-0 h2 w-100" v-model="form.title" placeholder="@lang('validation.attributes.title')" required autocomplete="title" autofocus>
                        </div>

                        <hr class="mb-5">

                        <div class="form-group">
                            <markdown-editor ref="body" v-model="form.body" @uploaded="addPath"></markdown-editor>
                        </div>

                        <div class="form-group">
                            <tags-select :old="form.tags" @change="updateTags"></tags-select>
                        </div>

                        <div v-if="uploadedImagesPath.length" class="form-group border px-3 py-2 mb-0">
                            <a class="text-black-50 mb-2" data-toggle="collapse" href="#uploadedImagesCollapse" role="button" aria-expanded="false" aria-controls="uploadedImagesCollapse">
                                @lang('developments.uploaded_images')
                            </a>

                            <ul class="collapse show list-unstyled mb-0" id="uploadedImagesCollapse">
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
                    </template>

                    <template v-else>
                        <h2 class="mb-5" v-text="form.title"></h2>

                        <div class="d-flex justify-content-between">
                            <div>
                                <a href="#" class="text-dark">
                                    {{ $development->user->name }}
                                </a>

                                <span class="mx-1">・</span>

                                <span class="text-black-50">
                                    {{ $development->created_at->format('Y. n. j. H:i') }}
                                </span>
                            </div>

                            <div class="d-flex align-items-center">
                                @auth
                                    <favorite :data="{{ $development }}"></favorite>

                                    <span class="mx-2">・</span>
                                @endauth

                                <clipboard class="text-black-50" data="{{ url()->current() }}">
                                    @lang(('developments.copy_url'))
                                </clipboard>

                                @can ('update', $development)
                                    <span class="ml-2">・</span>

                                    <div class="dropdown">
                                        <a id="editDropdown" class="dropdown-toggle-split text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            <i class="fas fa-list-ul"></i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="editDropdown">
                                            <a class="dropdown-item py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="edit">
                                                @lang('developments.edit')
                                                <i class="fas fa-pen"></i>
                                            </a>

                                            <form method="POST" action="{{ route('developments.destroy', $development->id) }}">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger py-3 d-flex justify-content-between align-items-center"
                                                        @click="destroy">
                                                    @lang('developments.delete')
                                                    <i class="far fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>

                        <hr class="mb-5">

                        <markdown-reader>@{{ form.body }}</markdown-reader>

                        <ul class="list-unstyled mb-0 d-flex mt-auto pt-4">
                            <li v-for="tag in tags" class="mr-2">
                                <span class="badge badge-light font-weight-normal px-3 py-2" v-text="`#${tag.name}`"></span>
                            </li>
                        </ul>
                    </template>
                </div>
            </div>

            <div v-if="! editing" class="row">
                <div class="col-md-6 offset-md-3 pb-6 text-center">
                    <h3 class="font-weight-bold">@lang('comments.title')</h3>

                    <p class="text-muted mb-4">@lang('comments.description')</p>

                    <comments :data="{{ $development->comments }}"></comments>
                </div>
            </div>
        </div>
    </development>
@stop
