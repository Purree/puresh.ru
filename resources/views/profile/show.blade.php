<x-app-layout>
    @if (session('error'))
        <div class="alert alert-danger">
            {{ __(session('error')) }}
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success">
            {{ __(session('success')) }}
        </div>
    @endif

    <div>
        @if (Laravel\Fortify\Features::canUpdateProfileInformation())
            @livewire('profile.update-profile-information-form')

            <x-jet-section-border/>

            @include('profile.external-integrations')

            <x-jet-section-border/>
        @endif

        @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
            @livewire('profile.update-password-form')

            <x-jet-section-border/>
        @endif

        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
            @livewire('profile.two-factor-authentication-form')

            <x-jet-section-border/>
        @endif

        @livewire('profile.logout-other-browser-sessions-form')

        @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
            <x-jet-section-border/>

            @livewire('profile.delete-user-form')
        @endif
    </div>
</x-app-layout>
