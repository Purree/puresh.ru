<div class="d-flex justify-content-between align-items-center text-break flex-column">
    <div class="d-flex w-100 flex-column">
        <div class="h5">
            {{ $file->name }}
        </div>
        <div class="h6 text-secondary">
            {{ $file->user->name }}
        </div>
    </div>
    <div class="w-100 d-flex">
        <button type="button" wire:click="download"
                class="btn w-100 btn-outline-success me-1">
            {{ __('Download') }}
        </button>
        @can('delete', $file)
            <button type="button" wire:click="delete"
                    class="btn w-100 btn-outline-danger ms-1">
                {{ __('Delete') }}
            </button>
        @endcan
    </div>
</div>
