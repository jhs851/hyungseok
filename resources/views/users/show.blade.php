@extends('layouts.app')

@section('content')
    <div class="container py-7">
        <h3 class="pb-2 mt-4 mb-2 border-bottom">
            {{ $user->name }}
            <small>Since {{ $user->created_at->diffForHumans() }}</small>
        </h3>

        @forelse ($developments as $development)
            <div class="card rounded-0 my-2">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('developments.show', ['$development' => $development->id]) }}">
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
        @empty
        @endforelse

        <div class="mt-3">
            {{ $developments->render() }}
        </div>
    </div>
@stop
