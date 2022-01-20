<?php

namespace App\Http\Livewire\Admin;

use App\Models\Permission;
use App\Models\User;
use App\Policies\PermissionPolicy;
use Livewire\Component;

class EditUser extends Component
{
    protected array $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email'
    ];
    protected array $allPermissions;

    public object $user;
    public array $permissions;

    public string $name;
    public string $email;
    public bool $deletePhoto;
    public array $givenPermissions = [];

    public $page;

    public function mount($page)
    {
        $this->page = $page;
    }

    public function render()
    {
        return view('livewire.admin.edit-user');
    }

    public function parseData(array $data): void
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->deletePhoto = isset($data['deletePhoto']);
        foreach ($this->permissions as $permission) {
            if(array_key_exists($permission, $data)){
                 $this->givenPermissions[$permission] = true;
            } else {
                $this->givenPermissions[$permission] = false;
            }
        }
        $this->validate();
    }

    public function editUser($submit)
    {
        $this->allPermissions = Permission::getAll();

        $this->parseData($submit);
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        if($this->deletePhoto) {
            $this->user->deleteProfilePhoto();
        }

        $userWithThisEmail = User::firstWhere('email', $this->email);
        if($userWithThisEmail !== null && $userWithThisEmail->id !== $this->user->id){
            return redirect($this->page)->with('error',"Пользователь с e-mail'ом $this->email уже существует.");
        }

        foreach ($this->givenPermissions as $permission => $value) {
            if (!in_array($permission, $this->allPermissions, true)) {
                continue;
            }

            // If set permission
            if ($value && !PermissionPolicy::isUserHasPermission($this->user, $permission)) {
                $this->user->permissions()->attach(array_search($permission, $this->allPermissions, true) + 1);
            }

            // If delete permission
            if (!$value && PermissionPolicy::isUserHasPermission($this->user, $permission)) {
                $this->user->permissions()->detach(array_search($permission, $this->allPermissions, true) + 1);
            }
        }

        $this->user->push();

        return redirect($this->page)->with('message',"Пользователь #{$this->user->id} ({$this->user->name}) успешно отредактирован.");
    }
}
