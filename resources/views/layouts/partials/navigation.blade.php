<navigation ref="navigation" inline-template @isset ($writing) :is-write="true" @endisset>
    <nav class="navbar navbar-expand-md navbar-{{ $theme ?? 'light' }} {{ isset($withoutDoorkeeper) ? '' : 'with-doorkeeper' }}">
        <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">HS</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown {{ str_contains(request()->path(), 'developments') ? 'active' : '' }}">
                    <a id="developmentDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        @lang('developments.title')
                    </a>

                    <div class="dropdown-menu" aria-labelledby="developmentDropdown">
                        <a class="dropdown-item" href="{{ route('developments.index') }}">
                            @lang('developments.title')
                        </a>

                        <a class="dropdown-item" href="{{ route('developments.create') }}">
                            @lang('developments.create')
                        </a>

                        @auth
                            <a class="dropdown-item" href="{{ route('developments.index', ['by' => auth()->user()->name]) }}">
                                @lang('developments.my_developments')
                            </a>
                        @endauth

                        <a class="dropdown-item" href="{{ route('developments.index', ['popularity' => 1]) }}">
                            @lang('developments.popularity')
                        </a>
                    </div>
                </li>

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">@lang('auth.login')</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">@lang('auth.register')</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @lang('auth.logout')

                            <form id="logout-form" action="{{ route('logout') }}" class="d-none" method="POST">
                                @csrf
                            </form>
                        </a>
                    </li>
                @endguest

                <li class="nav-item mr-2" v-if="writing || editing">
                    <a class="nav-link p-0">
                        <button class="btn btn-primary" @click.prevent="submit">
                            @lang('developments.submit') <i class="fas fa-file-alt ml-2"></i>
                        </button>
                    </a>
                </li>

                <li class="nav-item" v-if="editing">
                    <a class="nav-link p-0">
                        <button class="btn btn-outline-primary" @click.prevent="cancel">
                            @lang('developments.cancel') <i class="fas fa-ban ml-1"></i>
                        </button>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
</navigation>
