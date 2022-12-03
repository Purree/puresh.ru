<div>
    <x-integrations.block service-logo="pictures/main/vk_logo_light.png"
                            card-color="#07f">
        <x-slot:serviceData>
            <h5 class="fw-bold mb-0 text-light">{{ __('VKontakte') }}</h5>
            <span class="text-light">
            @if(auth()->user()->vk_id)
                    {{ __('Your') }}
                    <a class="text-white" target="_blank"
                       href="https://vk.com/id{{ auth()->user()->vk_id }}">{{ mb_strtolower(__('Account')) }}</a>
                    {{ mb_strtolower(__('Successfully linked')) }}.
                @else
                    {{ __('The service is not linked yet.') }}
                @endif
            </span>
        </x-slot:serviceData>
        <x-slot:serviceLinking>
            @if(auth()->user()->vk_id !== null)
                <form method="POST" class="mt-3 mt-sm-0" action="{{ route('unlink-vk-from-account') }}">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger text-light w-100">{{ __('Unlink') }}</button>
                </form>
            @else
                <a class="btn btn-light w-100"
                   href="https://oauth.vk.com/authorize?client_id={{ config('vk.APP_ID') }}&display=page&redirect_uri={{ route('link-vk-to-account') }}&scope=friends,notify,photos,audio,video,stories,pages,status,notes,wall,ads,offline,docs,groups,notifications,stats,email,market&response_type=code&v=5.131">
                    {{ __('Link') }}
                </a>
            @endif
        </x-slot:serviceLinking>
    </x-integrations.block>
</div>
