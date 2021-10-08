<div>
    <button wire:loading.attr="disabled" wire:click="deleteUser" data-id="{{ $user->id }}" class="btn btn-danger">
        Удалить
        <span class="spinner-border spinner-border-sm" role="status" wire:loading></span>
    </button>
</div>
