@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <development ref="form" inline-template :data="{{ $development }}">
                <div class="col-md-10 offset-md-1 p-3 p-md-6 bg-white shadow">
                    <div>
                        <template v-if="editing">
                            <markdown-helper></markdown-helper>

                            <div class="form-group">
                                <input type="text" ref="title" class="border-0 h2" v-model="form.title" placeholder="@lang('validation.attributes.title')" required autocomplete="title" autofocus>
                            </div>

                            <hr class="mb-5">

                            <div class="form-group mb-0">
                                <textarea class="border-0 w-100" v-model="form.body" placeholder="@lang('developments.body_placeholder')" required rows="30"></textarea>
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

                                <div class="d-flex">
                                    <clipboard class="text-black-50" data="{{ url()->current() }}">
                                        @lang(('developments.copy_url'))
                                    </clipboard>

                                    @can ($development, 'update')
                                        <span class="ml-2">・</span>

                                        <div class="dropdown">
                                            <a id="editDropdown" class="dropdown-toggle-split text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                                <i class="fas fa-list-ul"></i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right py-0 rounded-0" aria-labelledby="editDropdown">
                                                <a class="dropdown-item py-3 d-flex justify-content-between align-items-center" href="#" @click.prevent="edit">
                                                    @lang('developments.edit')
                                                    <i class="fas fa-pen"></i>
                                                </a>

                                                <form method="POST" action="{{ route('developments.destroy', compact('development')) }}">
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

                            <vue-markdown class="markdown-body" :task-lists="false">@{{ form.body }}</vue-markdown>
                        </template>
                    </div>
                </div>
            </development>
        </div>
    </div>
@stop
