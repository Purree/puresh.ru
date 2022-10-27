<div>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form wire:submit.prevent="saveFile">
        <div class="form-group">
            <label for="fileTitle">{{ __('File name') }}</label>
            <input class="form-control @error('name') is-invalid @enderror" wire:model="name"
                   id="fileTitle" placeholder="{{ __('Name') }}" type="text"
                   name="name" maxlength="255">
        </div>
        <div class="form-group">
            <label for="fileTitle">{{ __('File') }}</label>
            <input class="form-control @error('name') is-invalid @enderror" wire:model="file"
                   id="fileTitle" placeholder="{{ __('Name') }}" type="file"
                   name="name" maxlength="255">
        </div>

        <div class="mt-3">
            <button class="btn btn-danger" data-bs-toggle="collapse"
                    data-bs-target="#newFileCollapse" aria-expanded="false"
                    aria-controls="newFileCollapse" wire:click.prevent="">{{ __('Cancel') }}</button>
            <button class="btn btn-success" type="submit" wire:loading.attr="disabled">{{ __('Ready') }}</button>
            <div wire:loading>
                <div class="spinner-border" role="status"></div>
            </div>
        </div>
    </form>
</div>
