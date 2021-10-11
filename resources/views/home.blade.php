<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1" name="viewport">
    <title>Pure</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/home.css') }}">
</head>
<body>
<x-header>
   <li class="nav-item">
        <a class="nav-link" data-value="about" href="#about">Обо мне</a></li>
   <li class="nav-item">
        <a class="nav-link" data-value="technologies" href="#technologies">Технологии</a></li>
   <li class="nav-item">
        <a class="nav-link" data-value="contacts" href="#contacts">Контакты</a></li>
   <li class="nav-item dropdown">
        @auth
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('user') }}">Перейти в профиль</a></li>
        @endauth
</x-header>



<main class="main container pt-3 pb-3" role="main">
    <h2 id="about" class="anchor text-center mb-4 fw-bold">
        Обо мне
    </h2>
    <p>Меня зовут Кирилл и я - начинающий backend разработчик. Увлекаюсь разработкой примерно 2 года и каждый день учусь чему-то новому.</p>
    <p>За время своего обучения сделал много проектов для себя. Я очень трудолюбив, стрессоустойчив, быстро учусь и люблю узнавать что-то новое.</p>
    <p>Имею опыт в работе с чужим и legacy кодом, различными API, а также знаю и активно пользуюсь SOLID, DRY, KISS, а так же паттернами проектирования.</p>

    <h2 id="technologies" class="anchor text-center mb-4 mt-4 fw-bold">
        Технологии, которые я знаю
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
            <img class="img-fluid" src="{{ asset('pictures/main/bootstrap.png') }}" alt="bootstrap">
        </div>
        <div class="col-30 tech_img">
            <img class="img-fluid" src="{{ asset('pictures/main/laravel.png') }}" alt="laravel">
        </div>
        <div class="col-30 tech_img">
            <img class="img-fluid" src="{{ asset('pictures/main/mysql.png') }}" alt="mysql">
        </div>
    </div>
    <h2 id="contacts" class="anchor text-center fw-bold">
        Контакты
    </h2>
    <a href="https://vk.com/id149159673" class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links" target="_blank"><div class="col fake_block"></div><div class="col contact_content">ВКонтакте</div><div class="vkLogo col"></div></a>
    <a href="https://t.me/ppuurree" class="row align-items-center display-4 fw-bold  text-reset text-decoration-none contact_links" target="_blank"><div class="col fake_block"></div><div class="col contact_content">Telegram</div><div class="tgLogo col"></div></a>
    <a href="https://discord.gg/U8ndEXXnSw" class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links" target="_blank"><div class="col fake_block"></div><div class="col contact_content">Discord</div><div class="dsLogo col"></div></a>
    <a href="https://github.com/Purree/" class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links" target="_blank"><div class="col fake_block"></div><div class="col contact_content">GitHub</div><div class="ghLogo col"></div></a>
    <a href="mailto:kirill_malygin@internet.ru" class="row align-items-center display-4 fw-bold text-reset text-decoration-none contact_links" target="_blank"><div class="col fake_block"></div><div class="col contact_content">Почта</div><div class="mailLogo col"></div></a>
</main>

<footer class="footer text-muted sticky-top ">
    <div class="container mt-2 mb-2">
        <p>Основной функционал сайта открывается только с определёнными правами доступа. Если интересно, то напишите мне.</p>
        Связь со мной <a href="mailto:kirill_malygin@internet.ru">kirill_malygin@internet.ru</a> или через <a
            href="#contacts">другие сервисы</a>.
    </div>
</footer>
</body>
</html>
