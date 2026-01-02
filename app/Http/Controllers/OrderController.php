<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // <--- WAJIB: Tambahkan ini untuk PDF

class OrderController extends Controller
{
    // --- Method Bawaan Anda (Biarkan saja) ---
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

    // --- TAMBAHAN BARU: Method Cetak PDF ---
    public function printOrder(Request $request)
    {
        // 1. Ambil inputan filter dari URL (dikirim dari Filament)
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $status = $request->input('status');

        // 2. Siapkan Query
        // Gunakan 'with' agar loading data relasi lebih cepat (Optimasi)
        $query = Order::with(['customer', 'bundling']);

        // 3. Filter Tanggal (jika ada input)
        if ($startDate && $endDate) {
            // Filter berdasarkan 'book_date' (tanggal booking foto)
            $query->whereBetween('book_date', [$startDate, $endDate]);
        }

        // 4. Filter Status (jika bukan 'all')
        if ($status && $status !== 'all') {
            $query->where('order_status', $status);
        }

        // 5. Ambil data & Urutkan dari tanggal terlama ke terbaru
        $orders = $query->orderBy('book_date', 'asc')->get();

        // 6. Generate PDF
        // Pastikan nama file view sesuai: resources/views/pdf/order.blade.php
        $pdf = Pdf::loadView('pdf.order', [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        // Set ukuran kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // 7. Tampilkan di browser (Stream)
        return $pdf->stream('laporan-order.pdf');
    }
}