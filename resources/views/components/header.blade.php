<head>
    <link rel="stylesheet" href="{{ asset('css/header.css') }}">
    <link href="{{ asset('css/bootstrap-icons.css') }}" rel="stylesheet">
    <script src="{{ asset('js/theme.js') }}"></script>
</head>
<header class="d-flex py-4">
    <nav class="navbar header navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('main') }}">Главная</a>
            <button aria-controls="headerNav" aria-expanded="false" aria-label="Toggle navigation"
                    class="navbar-toggler"
                    data-bs-target="#headerNav" data-bs-toggle="collapse" type="button">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="headerNav">
                <ul class="navbar-nav mr-auto">
                    {{ $slot }}
                </ul>

                <hr/>

                <ul class="navbar-nav mr-auto">
                    <li class="nav-item" onclick="changeTheme()">
                        <a class="nav-link" data-value="theme"><i class="bi bi-moon"></i><i
                                class="bi bi-brightness-high"></i>
                            <div class="change_theme_text">Сменить тему</div>
                        </a>
                    </li>
                    <li class="nav-item">
                        @guest
                            <a class="nav-link" data-value="auth" href="{{ route('login') }}"><i
                                    class="bi bi-person-circle"></i>
                                <div class="auth_text">Войти или зарегистрироваться</div>
                            </a>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button"
                                        id="profileDropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img class="rounded-circle" width="32" height="32" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    <div class="auth_text">Действия над аккаунтом</div>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="profileDropdownMenuButton">
                                    <li><a class="dropdown-item" href="{{ route('profile.settings') }}">
                                            Настройки аккаунта
                                        </a></li>
                                    <li><form method="POST" class="dropdown-item dropdown-active" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-without-styles">
                                            Выйти из аккаунта
                                        </button>
                                    </form></li>
                                </ul>
                            </div>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
