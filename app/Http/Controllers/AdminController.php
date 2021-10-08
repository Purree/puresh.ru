<?php

namespace App\Http\Controllers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\Pure;

class AdminController extends Controller
{
    /**
     * Show all users
     *
     * @return View
     */
    public function showAllUsers(): View
    {
        $users = User::with('permissions')->paginate(15);
        $allPermissions = Permission::getAll();

        return view('admin.users', [
            'users' => $users,
            'permissions' => $allPermissions
        ]);
    }

    public function editUser()
    {
        redirect(route('admin.main'));
    }
}
