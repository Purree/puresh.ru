<div>
    <x-integrations.vk/>

    <div class="d-flex justify-content-center flex-column">
        <div class="mb-3">
            <div>
                @if($isVKUserDataNeedToShow)
                    <div class="card">
                        <livewire:integrations.vk.user-data/>
                    </div>
                @else
                    <div>
                        <button type="button" class="btn btn-outline-info mt-3 w-100" data-bs-toggle="collapse"
                                data-bs-target="#showVKDataCollapse" aria-expanded="false" wire:loading.attr="disabled"
                                aria-controls="showVKDataCollapse" wire:click="showVKUserData">
                            {{ __('Profile Information') }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
