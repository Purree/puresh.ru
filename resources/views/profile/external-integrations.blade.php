<x-jet-action-section>
    <x-slot name="title">
        {{ __('External integrations') }}
    </x-slot>

    <x-slot name="description">
        {{ __('External integrations linked to your account.') }}
    </x-slot>

    <x-slot name="content">
        <x-external-integration service-logo="pictures/main/vk_logo_light.png"
                            service-name="VKontakte"
                            service-description="The service is not linked yet."
                            service-authorization-link="https://oauth.vk.com/authorize?client_id={{ config('vk.APP_ID') }}&display=page&redirect_uri={{ route('link-vk-to-account') }}&scope=friends,notify,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email,market&response_type=code&v=5.131"
                            card-color="#07f"></x-external-integration>
    </x-slot>

</x-jet-action-section>
