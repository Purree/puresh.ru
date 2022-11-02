<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Pure</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/js/home/canvas.js'])
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/canvas.css') }}">
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <script src="{{ asset('js/theme.js') }}"></script>
</head>
<body>
<header class="d-flex py-4 position-fixed">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="navbar-collapse justify-content-end">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item align-self-center" onclick="changeTheme()">
                    <a class="nav-link" data-value="theme"><i class="bi bi-moon"></i><i
                            class="bi bi-brightness-high"></i>
                        <div class="change_theme_text">{{ __('Change theme') }}</div>
                    </a>
                </li>
                <li class="nav-item align-self-center">
                    <x-language_switcher></x-language_switcher>
                </li>
                <li class="nav-item align-self-center me-2">
                    @guest
                        <a class="nav-link" data-value="auth" href="{{ route('login') }}"><i
                                class="bi bi-person-circle"></i>
                            <div class="auth_text">{{ __('Login or register') }}</div>
                        </a>
                    @else
                        <div class="dropdown dropstart">
                            <button class="btn btn-secondary dropdown-toggle" type="button"
                                    id="profileDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="rounded-circle" width="32" height="32"
                                     src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                                <div class="auth_text">{{ __('Actions on the account') }}</div>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdownMenuButton">
                                <li><a class="dropdown-item" href="{{ route('profile.settings') }}">
                                        {{ __('Account settings') }}
                                    </a></li>
                                <li>
                                    <form method="POST" class="dropdown-item dropdown-active"
                                          action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-without-styles text-danger">
                                            {{ __('Logout') }}
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </li>
            </ul>
        </div>
    </nav>
</header>
<x-check-browser-support></x-check-browser-support>


<main class="main" role="main">
    <canvas></canvas>
    <div class="vh-100 d-flex flex-column justify-content-center align-items-center content">
        <div class="main-information-block">
            <div class="main-information d-flex flex-column align-items-center">
                <div class="avatar" style='background-image: url("{{ asset('pictures/main/avatar.jpg') }}")'></div>
                <div class="name">{{ __('Kirill Malygin') }}</div>
                <div class="competency">{{ __('Web developer') }}</div>
            </div>
            <div class="buttons-list">
                <a class="btn btn-dark" href="https://t.me/ppuurree"><i class="bi bi-telegram"></i> {{ __('Contact me') }}</a>
            </div>
        </div>
    </div>
</main>
</body>
</html>
