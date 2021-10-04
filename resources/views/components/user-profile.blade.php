<div class="row h-100 justify-content-center my-5 mt-5">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-body border-bottom rounded-top">
                <div class="mx-3 my-3">
                    <h3 class="h3 my-4">
                        Ваш профиль
                    </h3>

                    <div class="d-flex">
                        <div class="avatar me-3">
                            <img class="rounded-circle" width="80" height="80" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
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
                        Ваши права доступа:
                    </h3>

                    <div class="text">
                        {{-- Проверка прав пользователя, если он админ, остальные проверки не выполняются --}}
                        @can('administrate', App\Models\Permission::class)
                            <p class="text-danger">Вы администратор</p>
                        @else
                            @can('see_notes', App\Models\Permission::class)
                                <p class="text-info">Вы можете видеть заметки</p>
                            @endcan
                        @endcan

                        {{-- Проверка есть ли хоть одно право у пользователя, если нет вообще, то сообщение об этом --}}
                        @canany(['administrate', 'see_notes'], App\Models\Permission::class)
                        @else
                            Пока у вас нет прав ¯\_(ツ)_/¯
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

