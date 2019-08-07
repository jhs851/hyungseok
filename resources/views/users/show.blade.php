@extends('layouts.app')

@section('content')
    <div class="container pt-3 pb-5">
        <h3 class="pb-2 mt-4 mb-2 border-bottom d-flex align-items-center">
            <avatar :model="{{ $user }}">
                <img class="avatar mr-3" slot-scope="{ avatar }" :src="avatar" alt="">
            </avatar>

            {{ $user->name }}
        </h3>

        @forelse ($groups as $type => $activities)
            <h5 class="pb-2 mt-4 mb-2">@lang("auth.{$type}")</h5>

            @foreach ($activities as $activity)
                @includeIf("users.activities.{$activity->type}")
            @endforeach
        @empty
            <p class="text-center py-9 my-5">
                @lang('auth.empty_activities')
            </p>
        @endforelse
    </div>
@stop
