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
                wire:loading.attr="disabled"
                class="btn w-100 btn-outline-success me-1">
            {{ __('Download') }}
        </button>
        @can('manage_data', App\Models\Permission::class)
            <a type="button"
               href="{{ config('filesystems.disks.' . App\Helpers\Files\FileDrivers::getDriver() . '.url') . '/' . ($file->path) }}"
               target="_blank"
               class="btn w-100 btn-outline-info mx-1">
                {{ __('Show Content') }}
            </a>
        @endcan
        @can('delete', $file)
            <button type="button" wire:click="delete" wire:loading.attr="disabled"
                    class="btn w-100 btn-outline-danger ms-1">
                {{ __('Delete') }}
            </button>
        @endcan
    </div>
</div>
