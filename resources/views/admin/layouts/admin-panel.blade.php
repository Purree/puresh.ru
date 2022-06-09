<x-app-layout>
    <nav class="navbar navbar-expand pb-0">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto bg-dark border-bottom rounded-top">
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.users') ? 'active' : '' }}" href="{{ route('admin.users') }}">{{ __('Users') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::is('admin.IPs') ? 'active' : '' }}" href="{{ route('admin.IPs') }}">{{ __('IPs') }}</a>
                </li>
            </ul>
        </div>
    </nav>
    <div>
        {{ $slot }}
    </div>
</x-app-layout>
