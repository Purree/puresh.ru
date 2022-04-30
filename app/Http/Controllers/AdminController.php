<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\RestrictedIp;
use App\Models\User;
use App\Traits\Controller\CheckIsPaginatorPageExists;
use Illuminate\Contracts\View\View;

class AdminController extends Controller
{
    /**
     * Show all users
     *
     * @return View
     */
    use CheckIsPaginatorPageExists;

    public function showAllUsers()
    {
        $users = User::with('permissions', 'notes')->paginate(15);
        $allPermissions = Permission::getAll();

        $this->updatePageNumber();
        $this->validatePageNumber($users, 'admin.users');

        return view('admin.users', [
            'users' => $users,
            'permissions' => $allPermissions
        ]);
    }

    public function editUser()
    {
        $userId = request()->userId;
        if (is_null($userId)) {
            return redirect()->route('admin.main');
        }

        $allPermissions = Permission::getAll();

        return view('admin.editUser', [
            'user' => User::with('permissions')->findOrFail($userId),
            'permissions' => $allPermissions,
        ]);
    }

    public function showBlockedIPs()
    {
        $blockedIPs = RestrictedIp::paginate(30);

        $this->updatePageNumber();
        $this->validatePageNumber($blockedIPs, 'admin.IPs');

        return view('admin.blockedIPs', [
            'blockedIPs' => $blockedIPs
        ]);
    }
}
