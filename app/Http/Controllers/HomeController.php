<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $payment = null;

        // Check for session-based payment success (old flow)
        if (session('payment_success')) {
            $payment = Payment::with('order.bundling')
                ->find(session('payment_id'));
        }
        // Check for query parameter from Midtrans redirect (new flow)
        elseif ($request->has('payment_success') && $request->has('payment_id')) {
            $orderId = $request->get('payment_id');
            $payment = Payment::with('order.bundling')
                ->where('order_id', $orderId)
                ->first();
        }

        return view('home', compact('payment'));
    }
}
