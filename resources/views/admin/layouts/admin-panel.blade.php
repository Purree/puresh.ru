<x-app-layout>
    <style>
        .admin-tab-item:not(:last-child) {
            border-right: 2px solid var(--border_color);
        }
    </style>
    <nav class="navbar navbar-expand pb-0">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto bg-dark border-secondary border rounded-top">
                <li class="nav-item admin-tab-item">
                    <a class="nav-link text-light {{ Route::is('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">{{ __('Users') }}</a>
                </li>
                <li class="nav-item admin-tab-item">
                    <a class="nav-link text-light {{ Route::is('admin.IPs') ? 'active' : '' }}" href="{{ route('admin.IPs') }}">{{ __('IPs') }}</a>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        {{ $slot }}
    </div>
</x-app-layout>
