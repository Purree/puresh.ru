<div class="row h-100 justify-content-center my-5 mt-5">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body border-bottom rounded-top">
                <div class="mx-3 my-3">
                    <h3 class="h3 my-4">
                        {{ __('Profile Information') }}
                    </h3>

                    <div class="d-flex">
                        <div class="avatar me-3">
                            <img class="rounded-circle" width="80" height="80"
                                 src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}"/>
                        </div>
                        <div class="row flex-column justify-content-center">
                            <div class="name">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="email d-none d-sm-block">
                                {{ Auth::user()->email }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="mx-3 my-3">
                    <h3 class="h3 my-4">
                        {{ __('Permissions') }}:
                    </h3>

                    <div class="text">
                        {{-- Проверка прав пользователя, если он админ, остальные проверки не выполняются --}}
                        @can('manage_data', App\Models\Permission::class)
                            <p class="text-danger">{{ __('You are an administrator') }}</p>
                        @else
                            @can('see_events', App\Models\Permission::class)
                                <p class="text-info">{{ __('You can see') }} {{ mb_strtolower(__('Events')) }}</p>
                            @endcan
                            @can('see_notes', App\Models\Permission::class)
                                <p class="text-info">{{ __('You can see') }} {{ mb_strtolower(__('Notes')) }}</p>
                            @endcan
                            @can('see_randomizer', App\Models\Permission::class)
                                <p class="text-info">{{ __('You can see') }} {{ mb_strtolower(__('Randomizer')) }}</p>
                            @endcan
                        @endcan

                        {{-- Проверка есть ли хоть одно право у пользователя, если нет вообще, то сообщение об этом --}}
                        @canany(['manage_data', 'see_notes', 'see_events'], App\Models\Permission::class)
                        @else
                            {{ __('So far you have no rights') }} ¯\_(ツ)_/¯
                        @endcan
                        @if (Auth::user()->is_banned)
                            <p class="text-danger">{{ __('Also you are banned') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

