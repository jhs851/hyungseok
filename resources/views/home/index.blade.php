@extends('layouts.app')

@section('style')
    <style>
        #door {
            background: url({{ asset('images/backgrounds/light.jpg') }}) center / cover no-repeat;
            height: 450px;
        }

        #door h1 {
            letter-spacing: 2px;
        }

        @media (min-width: 768px) {
            #navigation {
                position: absolute;
                top: 15px;
                left: 15px;
                right: 15px;
                z-index: 1030;
            }

            main {
                padding: 15px;
                position: relative;
            }

            #door {
                height: calc(100vh - 30px);
            }

            #door h1 {
                letter-spacing: 10px;
            }
        }
    </style>
@stop

@section('content')
    <div id="door" class="d-flex justify-content-center align-items-center flex-column text-center mb-9">
        <h1 class="d-block d-md-none font-weight-bold mb-2 wow fadeInUp">
            @lang('home.main.title')
        </h1>

        <h1 class="d-none d-md-block font-weight-bold display-3 mb-4 wow fadeInUp">
            @lang('home.main.title')
        </h1>

        <h6 class="d-block d-md-none mb-2 pb-2 wow fadeInUp" data-wow-delay=".6s">
            @lang('home.main.description')
        </h6>

        <h3 class="d-none d-md-block mb-4 pb-2 wow fadeInUp" data-wow-delay=".6s">
            @lang('home.main.description')
        </h3>

        @component('layouts.components.line', [
            'classes' => 'wow fadeInUp mb-7',
            'attributes' => 'data-wow-delay="1.2s"',
        ]) @endcomponent
    </div>

    <div class="container mb-6">
        <div class="row mb-5">
            <div class="col-12">
                <h3 class="mb-3 text-center font-weight-bold wow fadeInUp">
                    @lang('home.latest_articles')
                </h3>

                @component('layouts.components.line', ['classes' => 'wow fadeInUp mx-auto', 'attributes' => 'data-wow-delay=".6s"']) @endcomponent
            </div>
        </div>

        <div class="row wow fadeInUp">
            @forelse ($developments as $index => $development)
                <div class="col-md-4">
                    <div class="card border-0 z-depth-1-half hvr-float">
                        <a class="overlay-link" href="{{ route('developments.show', ['development' => $development->id]) }}"></a>

                        <img class="card-img-top" src="{{ asset('images/developments/' . ($index + 1) . '.jpg') }}" alt="">

                        <div class="card-body pt-6 pb-5 px-5">
                            @component('layouts.components.line', ['classes' => 'mx-auto mb-4', 'width' => 40, 'height' => 3]) @endcomponent

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
