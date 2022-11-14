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
                                service-authorization-link="https://oauth.vk.com/authorize?client_id={{ config('vk.APP_ID') }}&display=page&redirect_uri={{ route('link-vk-to-account') }}&scope=friends,notify,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email,market&response_type=code&v=5.131"
                                :is-linked="auth()->user()->vk_id !== null"
                                card-color="#07f">
            <x-slot:serviceDescription>
                @if(auth()->user()->vk_id)
                    {{ __('Your') }}
                    <a class="text-white" target="_blank"
                       href="https://vk.com/id{{ auth()->user()->vk_id }}">{{ mb_strtolower(__('Account')) }}
                    </a>
                    {{ mb_strtolower(__('Successfully linked')) }}.
                @else
                    {{ __('The service is not linked yet.') }}
                @endif
            </x-slot:serviceDescription>
        </x-external-integration>
    </x-slot>

</x-jet-action-section>
