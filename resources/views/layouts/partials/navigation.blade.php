<nav id="navigaiton" class="navbar navbar-expand-md navbar-light fixed-top">
    <a class="navbar-brand py-0" href="{{ route('home') }}">
        <img class="img-fluid" src="{{ asset('images/etc/logo.png') }}" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            @hasSection('nav-left')
                @yield('nav-left')
            @else
                <li class="nav-item dropdown {{ str_contains(request()->path(), 'developments') ? 'active' : '' }}">
                    <a id="developmentDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
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
            @endif
        </ul>

        <ul class="navbar-nav">
            @hasSection('nav-right')
                @yield('nav-right')
            @else
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
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                @lang('auth.logout')
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            @endif
        </ul>
    </div>
</nav>
