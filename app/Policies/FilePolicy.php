<?php

namespace App\Policies;

use App\Models\File;
use App\Models\Permission;
use App\Models\User;
use Gate;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{
    use HandlesAuthorization;

    public function before()
    {
        if (Gate::allows('manage_data', Permission::class)) {
            return true;
        }
    }

    public function delete(User $user, File $file)
    {
        return $user->id === $file->user->id;
    }
}
