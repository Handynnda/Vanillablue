<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function printOrder(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        $query = Order::with(['customer', 'bundling']);

        if ($startDate && $endDate) {
            $query->whereBetween('book_date', [$startDate, $endDate]);
        }

        if ($status && $status !== 'all') {
            $query->where('order_status', $status);
        }

        $orders = $query->orderBy('book_date', 'asc')->get();

        $pdf = Pdf::loadView('pdf.order', [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-order.pdf');
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
    


