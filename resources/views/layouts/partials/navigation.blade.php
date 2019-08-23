{{-- Mobile Navbar --}}
<nav id="mobile-navbar" class="d-flex d-md-none navbar navbar-expand-md navbar-light fixed-top bg-white border-bottom">
    <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">HS</a>

    <div class="navbar-icon collapsed" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-label="{{ __('Toggle navigation') }}">
        <div class="navbar-icon-label" aria-hidden="true">
            <div class="navbar-icon-bread navbar-icon-bread-top">
                <div class="navbar-icon-bread-crust navbar-icon-bread-crust-top"></div>
            </div>
            <div class="navbar-icon-bread navbar-icon-bread-bottom">
                <div class="navbar-icon-bread-crust navbar-icon-bread-crust-bottom"></div>
            </div>
        </div>
    </div>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown {{ str_contains(request()->path(), 'developments') ? 'active' : '' }}">
                <a id="developmentDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @lang('developments.title')
                </a>

                <div class="dropdown-menu" aria-labelledby="developmentDropdown">
                    <a class="dropdown-item" href="{{ route('developments.index') }}">
                        @lang('developments.list')
                    </a>

                    <a class="dropdown-item" href="{{ route('developments.create') }}">
                        @lang('developments.create')
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
                <user-notifications></user-notifications>

                <li class="nav-item dropdown {{ str_contains(request()->path(), 'users') ? 'active' : '' }}">
                    <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        @unless (auth()->user()->hasVerifiedEmail)
                            <a class="dropdown-item bg-danger text-white" href="{{ route('verification.notice') }}">
                                @lang('auth.verify.title')
                            </a>
                        @endunless

                        <a class="dropdown-item" href="{{ route('users.show', ['user' => auth()->id()]) }}">
                            @lang('auth.activities')
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @lang('auth.logout')

                            <form id="logout-form" action="{{ route('logout') }}" class="d-none" method="POST">
                                @csrf
                            </form>
                        </a>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>

{{-- PC Navbar --}}
<navigation ref="navigation" inline-template {!! isset($writing) ? ':is-write="true"' : '' !!}>
    <nav id="pc-navbar" class="d-none d-md-flex navbar navbar-expand-md navbar-light" :class="writing || editing ? 'fixed-top bg-white border-bottom' : ''">
        <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">HS</a>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown {{ str_contains(request()->path(), 'developments') ? 'active' : '' }}">
                <a id="developmentDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    @lang('developments.title')
                </a>

                <div class="dropdown-menu" aria-labelledby="developmentDropdown">
                    <a class="dropdown-item" href="{{ route('developments.index') }}">
                        @lang('developments.list')
                    </a>

                    <a class="dropdown-item" href="{{ route('developments.create') }}">
                        @lang('developments.create')
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
                <user-notifications></user-notifications>

                <li class="nav-item dropdown {{ str_contains(request()->path(), 'users') ? 'active' : '' }}">
                    <a id="userDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ auth()->user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        @unless (auth()->user()->hasVerifiedEmail)
                            <a class="dropdown-item bg-danger text-white" href="{{ route('verification.notice') }}">
                                @lang('auth.verify.title')
                            </a>
                        @endunless

                        <a class="dropdown-item" href="{{ route('users.show', ['user' => auth()->id()]) }}">
                            @lang('auth.activities')
                        </a>

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            @lang('auth.logout')

                            <form id="logout-form" action="{{ route('logout') }}" class="d-none" method="POST">
                                @csrf
                            </form>
                        </a>
                    </div>
                </li>
            @endguest

            <li v-cloak class="nav-item mr-2" v-if="writing || editing">
                <a class="nav-link p-0">
                    <button class="btn btn-primary" @click.prevent="submit">
                        @lang('developments.submit') <i class="fas fa-file-alt ml-2"></i>
                    </button>
                </a>
            </li>

            <li v-cloak class="nav-item" v-if="editing">
                <a class="nav-link p-0">
                    <button class="btn btn-outline-primary" @click.prevent="cancel">
                        @lang('developments.cancel') <i class="fas fa-ban ml-1"></i>
                    </button>
                </a>
            </li>
        </ul>
    </nav>
</navigation>
