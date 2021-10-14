<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function administrate(User $user)
    {
        return $user->permissions->is_admin === true;
    }

    public function see_notes(User $user)
    {
        return $user->permissions->notes === true;
    }

    public function see_events(User $user)
    {
        return $user->permissions->events === true;
    }
}
