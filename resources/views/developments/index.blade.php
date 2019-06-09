@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <div class="row">
            <div class="offset-md-3 col-md-9">
                @forelse ($developments as $development)
                    <div class="card rounded-0 my-2">
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
                @empty
                    @lang('developments.empty')
                @endforelse
            </div>
        </div>
    </div>
@stop
