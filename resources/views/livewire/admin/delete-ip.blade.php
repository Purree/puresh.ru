<div>
    <button wire:loading.attr="disabled" wire:click="deleteIP" data-id="{{ $ip->id }}" class="btn btn-danger">
        {{ __('Delete') }}
        <span class="spinner-border spinner-border-sm" role="status" wire:loading></span>
    </button>
</div>
