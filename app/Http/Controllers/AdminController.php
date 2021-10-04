<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Contracts\View\View;

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
}
