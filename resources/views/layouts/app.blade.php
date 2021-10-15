<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        @livewireStyles

        <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased">
{{--        <x-jet-banner />--}}

        <!-- Page Heading -->
        <x-header>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('user') }}">Перейти в профиль</a></li>
            @can('manage_data', App\Models\Permission::class)
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.main') }}">Админ панель</a></li>
            @endcan
            @can('see_notes', App\Models\Permission::class)
                <li class="nav-item"><a class="nav-link" href="{{ route('notes') }}">Заметки</a></li>
            @endcan
            @can('see_events', App\Models\Permission::class)
                <li class="nav-item"><a class="nav-link" href="{{ route('events') }}">События</a></li>
            @endcan

        </x-header>

        <!-- Page Content -->
        <main class="container my-5">
            {{ $slot }}
        </main>

        @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
