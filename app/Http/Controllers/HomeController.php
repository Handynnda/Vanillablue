<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $payment = null;

        if (session('payment_success')) {
            $payment = Payment::with('order.bundling')
                ->find(session('payment_id'));
        }

        return view('home', compact('payment'));
    }
}
