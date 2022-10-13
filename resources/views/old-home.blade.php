<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Pure</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="module" src="{{ asset('js/mainPage/activeElementsHighlighting.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/home/old-home.css') }}">
    @stack('styles')
</head>
<body>
    <x-header>
       <li class="nav-item">
            <a class="nav-link" data-value="about" href="#about" data-id="1">{{ __('About me') }}</a></li>
       <li class="nav-item">
            <a class="nav-link" data-value="technologies" href="#technologies" data-id="2">{{ __('Technologies') }}</a></li>
       <li class="nav-item">
            <a class="nav-link" data-value="contacts" href="#contacts" data-id="3">{{ __('Contacts') }}</a></li>
       <li class="nav-item dropdown">
            @auth
                <li class="nav-item">
                    <a class="nav-link" href="{{ asset('user') }}">{{ __('Go to profile') }}</a></li>
            @endauth
    </x-header>
    <x-check-browser-support></x-check-browser-support>


    <main class="main container pt-3 pb-3" role="main">
        <div class="informationSection" data-id="1">
            <h2 id="about" class="anchor text-center mb-4 fw-bold">
                {{ __('About me') }}
            </h2>
            <p>{{ __('My name is Kirill, I am a backend developer. Interested in developing for about 2 years.') }}</p>
            <p>{{ __('I have experience in working with foreign and legacy code, various APIs, and I also know and actively use SOLID, DRY, KISS, as well as design patterns.') }}</p>
        </div>

        <div class="informationSection" data-id="2">
            <h2 id="technologies" class="anchor text-center mb-4 mt-4 fw-bold">
                {{ __('Technologies I have worked with') }}
            </h2>
            <div class="row justify-content-around align-items-center">
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/js.png') }}" alt="JS">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/html.png') }}" alt="HTML">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/css.png') }}" alt="CSS">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/python.png') }}" alt="php">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/php.png') }}" alt="php">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/nodejs.png') }}" alt="nodeJS">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/vue.png') }}" alt="vue js">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/react.png') }}" alt="react js">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/react-native.png') }}" alt="react-native">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/bootstrap.png') }}" alt="bootstrap">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/laravel.png') }}" alt="laravel">
                </div>
                <div class="col-30 tech_img">
                    <img class="img-fluid" src="{{ asset('pictures/main/mysql.png') }}" alt="mysql">
                </div>
            </div>
        </div>

        <div class="informationSection" data-id="3">
            <h2 id="contacts" class="anchor text-center fw-bold mt-3">
                {{ __('Contacts') }}
            </h2>
            <a href="https://vk.com/id149159673"
               class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links"
               target="_blank">
                <div class="col fake_block"></div>
                <div class="col contact_content">{{ __('VK') }}</div>
                <div class="vkLogo col"></div>
            </a>
            <a href="https://t.me/ppuurree"
               class="row align-items-center display-4 fw-bold  text-reset text-decoration-none contact_links"
               target="_blank">
                <div class="col fake_block"></div>
                <div class="col contact_content">Telegram</div>
                <div class="tgLogo col"></div>
            </a>
            <a href="https://discord.gg/U8ndEXXnSw"
               class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links"
               target="_blank">
                <div class="col fake_block"></div>
                <div class="col contact_content">Discord</div>
                <div class="dsLogo col"></div>
            </a>
            <a href="https://github.com/Purree/"
               class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links"
               target="_blank">
                <div class="col fake_block"></div>
                <div class="col contact_content">GitHub</div>
                <div class="ghLogo col"></div>
            </a>
            <a href="mailto:kirill_malygin@internet.ru"
               class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links"
               target="_blank">
                <div class="col fake_block"></div>
                <div class="col contact_content">{{ __('Mail') }}</div>
                <div class="mailLogo col"></div>
            </a>
        </div>
    </main>

    <footer class="footer text-muted sticky-top ">
        <div class="container mt-2 mb-2">
            <p>{{ __('The main functionality of the site is opened only with certain access rights. If interested, then write to me.') }}</p>
            {{ __('Contact me') }} <a href="mailto:kirill_malygin@internet.ru">kirill_malygin@internet.ru</a> {{ __('or through') }} <a
                href="#contacts">{{ __('other services') }}</a>.
        </div>
    </footer>
</body>
</html>
