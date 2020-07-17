<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <a class="navbar-brand" href="{{ url('/') }}">
    {{ config('app.name', 'Laravel') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

        @include('layouts.static_pages_menu')

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                </li>
            @else
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->login }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if(isset(Auth::user()->email_verified_at) && (string) Auth::user()->email_verified_at !== '')
                            <a href="{{ url('/cabinet') }}">В кабинет</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<nav class="main-left-navbar">
    <input type="checkbox" id="check" />
    <label for="check">
        <i class="fas fa-hat-cowboy main-left-navbar__show-hat"></i>
        <i class="fas fa-hat-cowboy-side main-left-navbar__hide-hat"></i>
    </label>
    @php $countMenu = 0; @endphp
    <div class="main-left-navbar__sidebar">
        <header>Мої сім’я Hello</header>
        <ul data-simplebar-direction='rtl'>
            @include('layouts.top_menu',['categories' => $categories])
        </ul>
    </div>
</nav>
