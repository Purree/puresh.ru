<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
        <link href="{{ asset('css/main/main.css') }}" rel="stylesheet">

        @vite(['resources/sass/app.scss', 'resources/js/app.js'])


        @livewireStyles

        <!--Styles-->
        @stack('styles')
        <!--Styles end-->
    </head>
    <body class="font-sans antialiased">
    <x-header>
        <li class="nav-item">
            <a class="nav-link {{ Route::is('user') ? 'active fw-bold' : '' }}" href="{{ route('user') }}">{{ __('Go to profile') }}</a>
        </li>
        @can('manage_data', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Request()->route()->getPrefix() === '/admin' ? 'active fw-bold' : '' }}" href="{{ route('admin.main') }}">{{ __('Admin panel') }}</a>
            </li>
        @endcan
        @can('see_notes', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('notes') ? 'active fw-bold' : '' }}" href="{{ route('notes') }}">{{ __('Notes') }}</a>
            </li>
        @endcan
        @can('see_events', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('events') ? 'active fw-bold' : '' }}" href="{{ route('events') }}">{{ __('Events') }}</a>
            </li>
        @endcan
        @can('see_randomizer', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('randomizer') ? 'active fw-bold' : '' }}" href="{{ route('randomizer') }}">{{ __('Randomizer') }}</a>
            </li>
        @endcan
        @can('see_files', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('files') ? 'active fw-bold' : '' }}" href="{{ route('files') }}">{{ __('Files') }}</a>
            </li>
        @endcan
        @can('see_integrations', App\Models\Permission::class)
            <li class="nav-item">
                <a class="nav-link {{ Route::is('integrations') ? 'active fw-bold' : '' }}" href="{{ route('integrations') }}">{{ __('Integrations') }}</a>
            </li>
        @endcan
    </x-header>
    <x-check-browser-support></x-check-browser-support>

    <main class="container py-3 bg-theme">
        {{ $slot }}
    </main>

    @stack('modals')

        @livewireScripts

        @stack('scripts')
    </body>
</html>
