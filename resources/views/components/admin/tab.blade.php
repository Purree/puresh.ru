<li class="nav-item admin-tab-item">
    <a class="nav-link text-light {{ Route::is($routeName) ? 'active' : '' }}" href="{{ route($routeName) }}">{{ __($text) }}</a>
</li>
