<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();

        return view('orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $order->update([
            'order_status' => $request->status
        ]);

        return back()->with('success', 'Status berhasil diperbarui');
    }

    public function myOrders()
    {
        $orders = Order::with(['bundling', 'payment'])
            ->where('customer_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('profile.histori', compact('orders'));
    }
}
