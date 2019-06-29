@extends('layouts.app')

@section('content')
    @doorkeeper(['title' => trans('home.main.title'), 'description' => trans('home.main.description')]) @enddoorkeeper

    <div class="container mb-6">
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="mb-3 text-center font-weight-bold wow fadeInUp">
                    @lang('home.latest_articles')
                </h3>

                @line(['classes' => 'wow fadeInUp mx-auto', 'attributes' => 'data-wow-delay=".6s"']) @endline
            </div>
        </div>

        <div class="row wow fadeInUp">
            @forelse ($developments as $index => $development)
                <div class="col-4">
                    <div class="card border-0 z-depth-1-half hvr-float">
                        <a class="overlay-link" href="{{ route('developments.show', ['development' => $development->id]) }}"></a>

                        <img class="card-img-top" src="{{ asset('images/developments/' . ($index + 1) . '.jpg') }}" alt="">

                        <div class="card-body pt-6 pb-5 px-5">
                            @line(['classes' => 'mx-auto mb-4', 'width' => 40, 'height' => 3]) @endline

                            <h4 class="card-title text-center">{{ $development->title }}</h4>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <small>
                                <i class="far fa-clock mr-1"></i>
                                {{ $development->created_at->format('Y. m. d') }}
                            </small>

                            <div>
                                <small class="mr-3">
                                    <i class="far fa-eye mr-1"></i>
                                    {{ $development->visits }}
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
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">
                        @lang('developments.empty')
                    </p>
                </div>
            @endforelse
        </div>
    </div>
@stop
