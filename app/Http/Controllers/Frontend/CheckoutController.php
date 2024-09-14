<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Cart;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('frontend.pages.checkout');
    }

    public function checkoutRedirect(Request $request)
    {
        $cartItems = Cart::content();
        $userId = auth()->id();

        // Use the cartTotal() helper function for the subtotal
        $subtotal = cartTotal(); // This will include product options and size prices

        $total = grandCartTotal(); // This will account for any applied coupon discounts

        // Create the order
        $order = Order::create([
            'user_id' => $userId,
            'subtotal' => $subtotal,
            'total' => $total,
            'discount' => session()->has('coupon') ? session()->get('coupon')['discount'] : 0,
            'status' => 'pending',
        ]);

        // Create order items
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item->name,
                'qty' => $item->qty,
                'price' => $item->price,
                'options' => json_encode($item->options), // Save options as JSON
            ]);
        }

        // Clear the cart
        Cart::destroy();

        // Add notification for the current user
        $currentUser = auth()->user();
        $this->addNotification($currentUser, 'Order created', 'Your order has been placed successfully!');

        // Add notification for the admin user
        $adminUser = User::where('role', 'admin')->first();
        if ($adminUser) {
            $this->addNotification($adminUser, 'New order', 'A new order has been placed.');
        }

        return redirect()->route('order.success')->with('message', 'Order placed successfully!');
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
}
