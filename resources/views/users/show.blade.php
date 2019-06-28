@extends('layouts.app')

@section('content')
    <div class="container py-7">
        <h3 class="pb-2 mt-4 mb-2 border-bottom">
            @can ('update', $user)
                <form id="avatar-form" class="d-inline-block" method="POST" action="{{ route('users.avatar.store', $user->id) }}" enctype="multipart/form-data">
                    @csrf

                    <label class="m-0">
                        <img class="img-fluid rounded-circle mr-2" src="{{ $user->avatar }}" alt="">
                        <input type="file" class="d-none" name="avatar" onchange="event.preventDefault(); document.getElementById('avatar-form').submit();">
                    </label>
                </form>
            @else
                <img class="img-fluid rounded-circle mr-2" src="{{ $user->avatar }}" alt="">
            @endcan

            {{ $user->name }}
        </h3>

        @forelse ($groups as $type => $activities)
            <h5 class="pb-2 mt-4 mb-2 border-bottom">@lang("auth.{$type}")</h5>

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
