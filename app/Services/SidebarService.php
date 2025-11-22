<?php

namespace App\Services;

// use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class SidebarService
{
    public static function get()
    {
        $rolesSubmenu = [];

        // foreach (Role::all() as $role) {
        //     if (in_array($role->name, ['Employers', 'Candidates'])) continue;

        //     $rolesSubmenu[] = [
        //         'title' => ucwords($role->name),
        //         'link' => route('admin.user_list', Str::slug($role->name)),
        //         'is_active' => Request::is('admin/user/' . $role->name),
        //         'permission' => 'user_list'
        //     ];
        // }

        return [
            [
                'title' => 'Dashboard',
                'icon' => '<i class="ri-dashboard-line"></i>',
                'link' => route('dashboard'),
                'is_active' => Request::is('admin/dashboard'),
                'permission' => 'dashboard',
            ],
            [
                'title' => 'Manage Users',
                'icon' => '<i class="ri-group-line"></i>',
                'link' => '#',
                'is_active' => Request::is('admin/user/*'),
                'submenu' => $rolesSubmenu,
                'permission' => 'users',
            ],
            // Add other menus...
        ];
    }
}
