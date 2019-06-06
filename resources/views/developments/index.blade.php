@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="offset-md-3 col-md-9">
                @forelse ($developments as $development)
                    <div class="card rounded-0 my-2">
                        <div class="card-header text-muted d-flex justify-content-between">
                            <small>{{ $development->created_at->format('Y. m. d.') }} {{ $development->isPrivate() ? '| 비공개' : '' }}</small>
                            <small>@lang('developments.visits', ['visits' => $development->visits])</small>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $development->title }}</h5>
                            <p class="card-text text-black-50">{{ $development->body }}</p>
                        </div>
                    </div>
                @empty
                    @lang('developments.empty')
                @endforelse
            </div>
        </div>
    </div>
@stop
