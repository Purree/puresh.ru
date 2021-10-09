<div>
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <form wire:submit.prevent="editUser(Object.fromEntries(new FormData($event.target)))">
        <div class="form-group">
            <label for="name">Name </label>
            @error('name')<label class="text-danger"><p>{{ $message }}</p></label> @enderror
            <input type="text" class="form-control" id="name" placeholder="User name" value="{{ $user->name }}" name="name" required>
        </div>
        <div class="form-group mt-4 mb-4">
            <label for="email">Email</label>
            @error('email') <label class="text-danger"><p>{{ $message }}</p></label> @enderror
            <input type="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email }}" name="email" required>
        </div>
        @foreach($permissions as $permission)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="{{ $permission }}" name="{{ $permission }}"
                       placeholder="{{ $permission }}" {{ $user->permissions->$permission ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $permission }}">{{ $permission }}</label>
            </div>
        @endforeach
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="deletePhoto" name="deletePhoto">
            <label class="form-check-label" for="deletePhoto">Delete user photo</label>
        </div>
        <button type="submit" class="btn btn-primary mt-2">
            Submit
            <span class="spinner-border spinner-border-sm" role="status" wire:loading></span>
        </button>
    </form>
</div>
