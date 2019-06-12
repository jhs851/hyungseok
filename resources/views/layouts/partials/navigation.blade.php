<navigation ref="navigation" inline-template @isset ($writing) :is-write="true" @endisset>
    <nav id="navigation" class="navbar navbar-expand-md navbar-light flex-md-column align-items-start border-bottom px-0 border-dark pb-md-2 mb-6">
        <a class="d-none d-md-block navbar-brand py-0 mb-4" href="{{ route('home') }}">
            <img class="img-fluid" src="{{ asset('images/etc/logo.png') }}" alt="">
        </a>

        <button class="navbar-toggler" type="button">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="d-none d-md-flex w-100 align-items-end">
            <div class="mr-auto">
                <ul class="navbar-nav">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link pl-0" href="{{ route('login') }}">@lang('auth.login')</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('auth.register')</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    @lang('auth.logout')
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown {{ str_contains(request()->path(), 'developments') ? 'active' : '' }}">
                        <a id="developmentDropdown" class="nav-link dropdown-toggle pl-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            @lang('developments.title')
                        </a>

                        <div class="dropdown-menu" aria-labelledby="developmentDropdown">
                            <a class="dropdown-item" href="{{ route('developments.index') }}">
                                @lang('developments.title')
                            </a>

                            <a class="dropdown-item" href="{{ route('developments.create') }}">
                                @lang('developments.create')
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

            <div>
                <ul class="navbar-nav">
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
        </div>
    </nav>
</navigation>
