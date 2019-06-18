@extends('layouts.app', ['theme' => 'dark'])

@section('content')
    @doorkeeper(['description' => trans('developments.description'), 'theme' => 'dark', 'mb' => 'mb-0']) @enddoorkeeper

    <div class="container" style="margin-top: -130px;">
        <div class="row">
            <div class="col-md-10 offset-md-1 p-3 p-md-5 bg-white shadow" style="min-height: 800px;">
                <development ref="form" inline-template :data="{{ $development }}">
                    <div>
                        <template v-if="editing">
                            <markdown-helper></markdown-helper>

                            <div class="form-group">
                                <input type="text" ref="title" class="border-0 h2" v-model="form.title" placeholder="@lang('validation.attributes.title')" required autocomplete="title" autofocus>
                            </div>

                            <hr class="mb-5">

                            <div class="form-group mb-0">
                                <markdown-editor ref="body" v-model="form.body" :configs="simpleMDEConfigs"></markdown-editor>
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

                            <vue-markdown class="markdown-body" :task-lists="false" @rendered="enablePrism">@{{ form.body }}</vue-markdown>
                        </template>
                    </div>
                </development>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 offset-md-3 py-6 text-center">
                <h3 class="font-weight-bold">@lang('comments.title')</h3>

                <p class="text-muted mb-4">@lang('comments.description')</p>

                @forelse ($development->comments as $comment)
                    <div class="media my-5 text-left">
                        <img src="//via.placeholder.com/64x64" class="img-fluid mr-3 rounded-circle" alt="">
                        <div class="media-body">
                            <h6 class="mt-0 d-flex align-items-end">
                                <a href="#">
                                    {{ $comment->user->name }}
                                </a>

                                <small class="text-muted ml-2">
                                    {{ $comment->created_at->diffForHumans() }}
                                </small>
                            </h6>

                            <div class="small">
                                {{ $comment->body }}
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

                <form method="POST" action="#">
                    @csrf

                    <div class="form-group mb-4">
                        <textarea name="body" class="form-control rounded-0 p-3" placeholder="@lang('comments.placehoder')"></textarea>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-outline-primary rounded-0 px-4 font-weight-bold">@lang('comments.store')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop
