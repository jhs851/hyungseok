@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <div class="row py-5">
            <div class="col-12 p-3 p-md-5 bg-white shadow d-flex flex-column" style="min-height: 800px;">
                <h2 class="mb-5">{{ $development->title }}</h2>

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
                        <favorite :data="{{ $development }}"></favorite>

                        <span class="mx-2">・</span>

                        <clipboard class="text-black-50" data="{{ url()->current() }}">
                            @lang(('developments.copy_url'))
                        </clipboard>

                        <span class="ml-2">・</span>

                        <div class="dropdown">
                            <a id="editDropdown" class="dropdown-toggle-split text-black-50" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-list-ul"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="editDropdown">
                                <a class="dropdown-item py-3 d-flex justify-content-between align-items-center" href="{{ route('admin.developments.edit', $development->id) }}">
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
                    </div>
                </div>

                <hr class="mb-5">

                <vue-markdown class="markdown-body" :task-lists="false" @rendered="enablePrism">{{ $development->body }}</vue-markdown>

                <ul class="list-unstyled mb-0 d-flex mt-auto">
                    @foreach ($development->tags as $tag)
                        <li class="mr-2">
                            <span class="badge badge-light font-weight-normal px-3 py-2">{{ $tag->name }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="col-md-6 offset-md-3 pb-6 text-center">
            <h3 class="font-weight-bold">@lang('comments.title')</h3>

            <p class="text-muted mb-4">@lang('comments.description')</p>

            <comments :data="{{ $development->comments }}"></comments>
        </div>
    </div>
@stop