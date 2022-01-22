<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PermissionPolicy
{
    use HandlesAuthorization;

    public static function isUserHasPermission(User $user, string $permission): bool
    {
        return $user->permissions()->pluck('name')->contains($permission);
    }

    /**
     * Perform pre-authorization checks.
     *
     * @param  User  $user
     * @return void|bool
     */
    public function before(User $user)
    {
        if (self::isUserHasPermission($user, 'is_admin')) {
            return true;
        }
    }

    public function manage_data(User $user): bool
    {
        return self::isUserHasPermission($user, 'is_admin');
    }

    public function see_notes(User $user): bool
    {
        return self::isUserHasPermission($user, 'notes');
    }

    public function see_events(User $user): bool
    {
        return self::isUserHasPermission($user, 'events');
    }

    public function see_randomizer(User $user): bool
    {
        return self::isUserHasPermission($user, 'randomize');
    }
}
