<div>
    <button wire:loading.attr="disabled" wire:click="deleteSession" data-id="{{ $session->id }}" class="btn btn-danger">
        {{ __('Delete') }}
        <span class="spinner-border spinner-border-sm" role="status" wire:loading></span>
    </button>
</div>
