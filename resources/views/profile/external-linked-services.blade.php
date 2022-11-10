<x-jet-action-section>
    <x-slot name="title">
        {{ __('External services') }}
    </x-slot>

    <x-slot name="description">
        {{ __('External services linked to your account.') }}
    </x-slot>

    <x-slot name="content">
        <x-external-service service-logo="pictures/main/vk_logo_light.png"
                            service-name="VKontakte"
                            service-description="The service is not linked yet."
                            link="https://oauth.vk.com/authorize?client_id=51472897&display=page&redirect_uri=http://puresh.ru/user/services/vk&scope=friends,notify,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email,market&response_type=code&v=5.131"
                            card-color="#07f"></x-external-service>
    </x-slot>

</x-jet-action-section>
