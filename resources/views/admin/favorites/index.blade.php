@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid p-5">
        <div class="row">
            @component('admin.layouts.components.card')
                <div class="d-flex flex-column py-3 px-4 h-100">
                    <h4 class="text-muted font-weight-bold">
                        @lang('admin.favorites.total')
                    </h4>

                    <h1 class="display-4 mb-auto">{{ number_format($favorites->total()) }}</h1>
                </div>
            @endcomponent

            @if ($mostFavorited)
                @component('admin.layouts.components.card')
                    <div class="d-flex flex-column h-100 py-3 px-4">
                        <h4 class="text-muted font-weight-bold">
                            @lang('admin.favorites.most_favorited')
                        </h4>

                        <h1>
                            <a href="{{ route('admin.developments.show', $mostFavorited->id) }}">
                                {{ $mostFavorited->title }}
                            </a>
                        </h1>

                        <h3 class="text-right mt-auto">
                            {{ $mostFavorited->favorites_count }}
                        </h3>
                    </div>
                @endcomponent
            @endif
        </div>

        <div class="row mt-5 align-items-end">
            <div class="col-12">
                <div class="row align-items-end">
                    <div class="col-auto">
                        <h2 class="mb-3">@lang('admin.favorites.title')</h2>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="table-responsive bg-white z-depth-1 rounded-lg">
                            <table class="table table-hover text-center h5 font-weight-light mb-0">
                                <colgroup>
                                    <col style="width: 5%;">
                                    <col style="width: 10%;">
                                    <col style="width: 15%;">
                                    <col>
                                    <col style="width: 12%;">
                                    <col style="width: 8%;">
                                </colgroup>

                                <thead class="thead-light">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">@lang('admin.favorites.writer')</th>
                                        <th scope="col">@lang('admin.favorites.type')</th>
                                        <th class="text-left" scope="col">@lang('admin.favorites.favorited_post')</th>
                                        <th scope="col">@lang('admin.favorites.created_at')</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse ($favorites as $favorite)
                                        <tr>
                                            <td>{{ $favorite->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.users.show', $favorite->user_id) }}">
                                                    {{ $favorite->user->name }}
                                                </a>
                                            </td>
                                            <td>{{ $favorite->favorited_type }}</td>
                                            <td class="text-left">
                                                <a href="{{ route('admin.developments.show', $favorite->favorited->id) }}">
                                                    {{ $favorite->favorited->title }}
                                                </a>
                                            </td>
                                            <td>{{ $favorite->created_at->format('Y. m. d') }}</td>
                                            <td>
                                                <a href="{{ route('admin.developments.show', $favorite->favorited->id) }}" class="text-black-50 h4 mb-0">
                                                    <i class="far fa-eye"></i>
                                                </a>

                                                <form class="d-inline ml-2" method="POST" action="{{ route('admin.favorites.destroy', $favorite->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="btn btn-link p-0" @click="destroy">
                                                        <i class="far fa-trash-alt text-black-50 h4 mb-0"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                @lang('admin.favorites.empty')
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
