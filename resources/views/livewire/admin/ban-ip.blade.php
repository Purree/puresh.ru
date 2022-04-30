<div>
    @error('ip') <div class="text-danger">{{ $message }}</div> @enderror
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    <div class="input-group mb-3">
        <input wire:model.lazy="ip" type="text" class="form-control" placeholder="IP" aria-label="IP">
        <div class="input-group-append">
            <button class="btn btn-outline-danger" wire:click="ban" type="button">{{ __('Ban') }}</button>
        </div>
    </div>
</div>
