<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    function index() : View{
        return view('admin.index');

    }
    function notifications() : View{
        $adminUser = User::where('role', 'admin')->first();
        $notifications = json_decode($adminUser->notifications, true);
        $notifications = array_reverse($notifications);

        return view('admin.notifications.index', compact('notifications'));

    }
}

