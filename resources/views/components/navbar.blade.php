<nav class="navbar navbar-expand-md navbar-light bg-white shadow-xs">
    <div class="container-fluid">
        @auth
            @if (auth()->user()->type == 'user')
                <a class="navbar-brand m-1" href="{{ route('home') }}">
                    @include('components.logo')
                    AYORENT
                </a>
            @else
                <a class="navbar-brand m-1" href="{{ route('admin.dashboard') }}">
                    @include('components.logo')
                    AYORENT
                </a>
            @endif
        @endauth
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                @auth
                    @if (auth()->user()->type == 'user')
                        <li class="nav-item"><x-nav-link href="{{ route('user') }}" :active="request()->is('user')">Home</x-nav-link>
                        </li>
                        <li class="nav-item"><x-nav-link href="{{ route('history') }}"
                                :active="request()->is('history')">History</x-nav-link></li>
                    @else
                        <li class="nav-item"><x-nav-link href="{{ route('admin.dashboard') }}"
                                :active="request()->is('admin.dashboard')">Home</x-nav-link></li>
                    @endif
                @endauth

                <!-- Show "Cars" link only for admin -->
                @auth
                    @if (auth()->user()->type == 'admin')
                        <li class="nav-item"><x-nav-link href="{{ route('car.index') }}" :active="request()->is('car')">Cars</x-nav-link>
                        </li>
                    @endif
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto mr-2">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
