@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="card rounded-0 my-2">
                    <div class="card-header">
                        @lang('developments.trending')
                    </div>

                    <div class="card-body">
                        <ul class="list-group">
                            @foreach ($trending as $development)
                                <li class="list-group-item">
                                    <a href="{{ $development->path }}">
                                        {{ $development->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            @if ($developments->total())
                <div class="col-md-8">
                    @foreach ($developments as $development)
                        <div class="card rounded-0 my-2">
                            <div class="card-header text-muted d-flex justify-content-between">
                                <a href="{{ route('users.show', ['user' => $development->user->id]) }}">{{ $development->user->name }}</a>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <a href="{{ route('developments.show', ['development' => $development->id]) }}">
                                        {{ $development->title }}
                                    </a>
                                </h5>

                                <p class="card-text text-black-50">{{ str_limit($development->body) }}</p>
                            </div>

                            <div class="card-footer d-flex justify-content-between">
                                <small>
                                    <i class="far fa-clock mr-1"></i>
                                    {{ $development->created_at->format('Y. m. d') }}
                                </small>

                                <div>
                                    <small class="mr-3">
                                        <i class="far fa-eye mr-1"></i>
                                        0
                                    </small>

                                    <small class="mr-3">
                                        <i class="far fa-comment mr-1"></i>
                                        {{ $development->comments_count }}
                                    </small>

                                    <small>
                                        <i class="far fa-heart mr-1"></i>
                                        {{ $development->favorites_count }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div class="mt-3">
                        {{ $developments->render() }}
                    </div>
                </div>
            @else
                <div class="col-8">
                    <p class="text-center py-9 my-5">
                        @lang('developments.empty')
                    </p>
                </div>
            @endif
        </div>
    </div>
@stop
