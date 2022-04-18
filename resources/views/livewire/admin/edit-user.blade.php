<div class="card shadow">
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
    <form class="card-body border-bottom rounded-top" wire:submit.prevent="editUser(Object.fromEntries(new FormData($event.target)))">
        <div class="form-group">
            <label for="name">{{__('Name')}} </label>
            @error('name')<label class="text-danger"><p>{{ $message }}</p></label> @enderror
            <input type="text" class="form-control" id="name" placeholder="User name" value="{{ $user->name }}"
                   name="name" required>
        </div>
        <div class="form-group mt-4 mb-4">
            <label for="email">{{__('Email')}}</label>
            @error('email') <label class="text-danger"><p>{{ $message }}</p></label> @enderror
            <input type="email" class="form-control" id="email" placeholder="Email" value="{{ $user->email }}"
                   name="email" required>
        </div>
        @foreach($permissions as $permission)
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="{{ $permission }}" name="{{ $permission }}"
                       placeholder="{{ $permission }}" {{ \App\Policies\PermissionPolicy::isUserHasPermission($user, $permission) ? 'checked' : '' }}>
                <label class="form-check-label" for="{{ $permission }}">{{ $permission }}</label>
            </div>
        @endforeach
        <div class="form-check">
            <input type="checkbox" class="form-check-input" id="deletePhoto" name="deletePhoto">
            <label class="form-check-label" for="deletePhoto">Delete user photo</label>
        </div>

        <div>
            @if ($user->is_banned)
                <button wire:click.prevent="unban" class="btn btn-success">Разбанить</button>
            @else
                <button wire:click.prevent="ban" class="btn btn-danger">Забанить</button>
            @endif
        </div>

        <div>
            <button type="submit" class="btn btn-primary mt-2">
                {{__('Save')}}
                <span class="spinner-border spinner-border-sm" role="status" wire:loading></span>
            </button>
        </div>
    </form>
</div>
