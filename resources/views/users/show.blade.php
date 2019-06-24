@extends('layouts.app')

@section('content')
    <div class="container py-7">
        <h3 class="pb-2 mt-4 mb-2 border-bottom">
            {{ $user->name }}
        </h3>

        @forelse ($groups as $type => $activities)
            <h5 class="pb-2 mt-4 mb-2 border-bottom">@lang("auth.{$type}")</h5>

            @foreach ($activities as $activity)
                @include("users.activities.{$activity->type}")
            @endforeach
        @empty
        @endforelse
    </div>
@stop