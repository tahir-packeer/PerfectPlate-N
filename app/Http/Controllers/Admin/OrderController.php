<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Display a listing of the orders.
     */
    public function index(): View
    {
        $orders = Order::with('user', 'items')->paginate(10);
        return view('admin.order.index', compact('orders'));
    }

    /**
     * Show the details of the specified order.
     */
    public function show($id): View
    {
        $order = Order::with('user', 'items')->findOrFail($id);
        return view('admin.order.show', compact('order'));
    }

    /**
     * Update the specified order's status.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        try {
            $order = Order::findOrFail($id);
            $order->status = $request->status;
            $order->save();

            // Add notification with order ID and status
            $user = $order->user;
            $this->addNotification($user, 'Order status updated', 'Your order #'.$order->id.' status has been updated to '.$order->status);

            session()->flash('success', 'Order status updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'There was a problem updating the order status.');
        }

        return redirect()->route('order.index');
    }

    /**
     * Helper method to add a notification to a user
     */
    private function addNotification($user, $type, $message)
    {
        $notifications = json_decode($user->notifications, true) ?? [];
        $newId = count($notifications) > 0 ? max(array_column($notifications, 'id')) + 1 : 0;

        $newNotification = [
            'id' => $newId,
            'type' => $type,
            'message' => $message,
        ];

        $notifications[] = $newNotification;
        $user->notifications = json_encode($notifications);
        $user->save();
    }

    /**
     * Remove the specified order from storage.
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return redirect()->route('order.index')->with('success', 'Order deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('order.index')->with('error', 'Failed to delete order.');
        }
    }
}
