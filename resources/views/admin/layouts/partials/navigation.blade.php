<nav class="side-navbar navbar navbar-expand-md navbar-dark">
    <a class="navbar-brand bg-secondary" href="{{ route('home') }}">
        <i class="fas fa-home"></i>
        {{ config('app.name') }}
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sideNavbarCollapse" aria-controls="sideNavbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse bg-tertiary" id="sideNavbarCollapse">
        <ul class="navbar-nav">
            <li class="nav-item {{ Str::contains(request()->path(), 'dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}" class="nav-link">
                    <i class="fas fa-chart-line"></i> @lang('admin.dashboard.title')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'developments') ? 'active' : '' }}">
                <a href="{{ route('admin.developments.index') }}" class="nav-link">
                    <i class="far fa-newspaper"></i> @lang('developments.title')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'comments') ? 'active' : '' }}">
                <a href="{{ route('admin.comments.index') }}" class="nav-link">
                    <i class="far fa-comment"></i> @lang('admin.comments.title')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'tags') ? 'active' : '' }}">
                <a href="{{ route('admin.tags.index') }}" class="nav-link">
                    <i class="fas fa-tags"></i> @lang('validation.attributes.tags')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'favorites') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-heart"></i> @lang('admin.favorites.title')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'notifications') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-bell"></i> @lang('admin.notifications.title')
                </a>
            </li>

            <li class="nav-item {{ Str::contains(request()->path(), 'users') ? 'active' : '' }}">
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i> @lang('admin.users.title')
                </a>
            </li>
        </ul>
    </div>
</nav>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="avatar avatar-sm z-depth-0 mr-2" src="{{ auth()->user()->avatar }}" alt="">
                    {{ auth()->user()->name }}
                </a>

                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        @lang('auth.logout')

                        <form id="logout-form" action="{{ route('logout') }}" class="d-none" method="POST">
                            @csrf
                        </form>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
