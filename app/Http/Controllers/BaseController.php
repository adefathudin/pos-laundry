<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;

class BaseController extends Controller
{
    public function __construct()
    {
        // Data yang ingin tersedia di semua view
        
        $menus = [
            'appName' => config('app.name'),     
            'appVersion' => config('app.version'),
            'activeMenu' => '/'. request()->segment(1),
            'user' => auth()->user(),
            // 'userRole' => auth()->user()->role,
            // 'userName' => auth()->user()->name,
            // 'userEmail' => auth()->user()->email,
            'menu' => [
                [
                    'name' => 'Dashboard',
                    'url' => '/home',
                    'icon' => 'fa fa-home',
                ],
                [
                    'name' => 'Products',
                    'url' => '/products',
                    'icon' => 'fa fa-box',
                ],
                [
                    'name' => 'Transaction',
                    'url' => '/transaction',
                    'icon' => 'fa fa-cash-register',
                ],
                [
                    'name' => 'Reports',
                    'url' => '/reports',
                    'icon' => 'fa fa-chart-bar',
                ],
                [
                    'name' => 'Settings',
                    'url' => '/settings',
                    'icon' => 'fa fa-cog',
                ],
                [
                    'name' => 'Logout',
                    'url' => '/logout',
                    'icon' => 'fa fa-sign-out-alt',
                ],
            ],
        ];

        // Share data ke semua view
        View::share('menus', $menus);
    }
}
