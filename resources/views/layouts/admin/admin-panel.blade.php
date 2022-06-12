<x-app-layout>
    <style>
        .admin-tab-item:not(:last-child) {
            border-right: 2px solid var(--border_color);
        }
    </style>
    <nav class="navbar navbar-expand pb-0">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto bg-dark border-secondary border rounded-top">
                <x-admin.tab :routeName="'admin.users'" :text="'Users'"/>
                <x-admin.tab :routeName="'admin.IPs'" :text="'IPs'"/>
            </ul>
        </div>
    </nav>
    <div>
        {{ $slot }}
    </div>
</x-app-layout>
