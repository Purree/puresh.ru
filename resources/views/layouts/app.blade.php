<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
    <x-header>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('user') ? 'active fw-bold' : '' }}" href="{{ route('user') }}">Перейти в профиль</a>
        </li>
        @can('manage_data', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('admin.main') ? 'active fw-bold' : '' }}" href="{{ route('admin.main') }}">Админ
                    панель</a>
            </li>
        @endcan
        @can('see_notes', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('notes') ? 'active fw-bold' : '' }}" href="{{ route('notes') }}">Заметки</a>
            </li>
        @endcan
        @can('see_events', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('events') ? 'active fw-bold' : '' }}" href="{{ route('events') }}">События</a>
            </li>
        @endcan

    </x-header>

    <main class="container my-5">
        {{ $slot }}
    </main>

    @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
