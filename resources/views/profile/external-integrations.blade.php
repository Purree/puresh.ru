<x-jet-action-section>
    <x-slot name="title">
        {{ __('External integrations') }}
    </x-slot>

    <x-slot name="description">
        {{ __('External integrations linked to your account.') }}
    </x-slot>

    <x-slot name="content">
        <x-integrations.all/>
    </x-slot>

</x-jet-action-section>
