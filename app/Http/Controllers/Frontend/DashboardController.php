<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index(): View {
        $orders = Order::where('user_id', Auth::id())->with('items')->get();
        $user = auth()->user();
        $notifications = json_decode($user->notifications, true);
        return view('frontend.dashboard.index', compact('orders', 'notifications'));
    }

    public function showOrderInvoice($id): View {
        $order = Order::with('items')->findOrFail($id);
        return view('frontend.dashboard.invoice', compact('order'));
    }
}
