@extends('layouts.app')

@section('content')
    <h5 class="mb-4">
        @lang('developments.title')
    </h5>

    <div class="row">
        @forelse ($developments as $development)
            <div class="col-md-6">
                <div class="card rounded-0 wow fadeInUp">
                    <div class="card-header text-muted d-flex justify-content-between">
                        <small>{{ $development->created_at->format('Y. m. d.') }}</small>
                        <small>@lang('developments.visits', ['visits' => 0])</small>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('developments.show', ['$development' => $development->id]) }}">
                                {{ $development->title }}
                            </a>
                        </h5>

                        <p class="card-text text-black-50">{{ str_limit($development->body) }}</p>
                    </div>
                </div>
            </div>
        @empty
        @endforelse
    </div>
@stop
