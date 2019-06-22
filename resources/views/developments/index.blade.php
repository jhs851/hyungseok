@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @if ($developments->total())
                @foreach ($developments as $development)
                    <div class="col-md-12">
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

                                    <small>
                                        <i class="far fa-comment mr-1"></i>
                                        {{ $development->comments_count }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="col-12 mt-3">
                    {{ $developments->render() }}
                </div>
            @else
                <div class="col-12">
                    <p class="text-center py-9 my-5">
                        @lang('developments.empty')
                    </p>
                </div>
            @endif
        </div>
    </div>
@stop
