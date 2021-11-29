<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param User $user
     * @param string $ability
     * @return void|bool
     */
    public function before(User $user, string $ability)
    {
        if ($user->permissions->is_admin) {
            return true;
        }
    }

    public function manage_data(User $user): bool
    {
        return (boolean)$user->permissions->is_admin;
    }

    public function see_notes(User $user): bool
    {
        return (boolean)$user->permissions->notes;
    }

    public function see_events(User $user): bool
    {
        return (boolean)$user->permissions->events;
    }
}
