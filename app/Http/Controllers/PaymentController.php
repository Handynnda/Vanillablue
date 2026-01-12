<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Menampilkan formulir pembayaran
     */
    public function create($orderId)
    {
        // Pastikan User Login & ID valid (Bukan 0)
        if (!Auth::check() || Auth::id() === 0) {
            return redirect()->route('login')->with('error', 'Sesi Anda tidak valid. Silakan login kembali.');
        }

        $order = Order::findOrFail($orderId);

        // Proteksi: Hanya pemilik pesanan yang bisa bayar
        if ($order->customer_id !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('payment', compact('order'));
    }

    /**
     * Menyimpan data pembayaran menggunakan Cloudinary Disk
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'amount'          => 'required|string',
            'payment_date'    => 'required|date',
            'payment_method'  => 'required|in:bank_a,bank_b,bank_c',
            'proof_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $order = Order::findOrFail($data['order_id']);

        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $amount = (int) str_replace('.', '', $data['amount']);
        $minPayment = $order->total_price * 0.5;

        if ($amount < $minPayment) {
            return back()
                ->with('error', 'Minimal pembayaran adalah 50% dari total.')
                ->withInput();
        }

        // Upload bukti
        $path = null;
        if ($request->hasFile('proof_image')) {
            $file = $request->file('proof_image');
            $stored = $file->store('payments', 'cloudinary');

            $info = pathinfo($stored);
            $publicId = ($info['dirname'] !== '.' ? $info['dirname'].'/' : '').$info['filename'];

            $asset = Cloudinary::adminApi()->asset($publicId);
            $path = $asset['secure_url'];
        }

        $payment = Payment::create([
            'order_id'       => $order->id,
            'payment_code'   => 'PYM-' . strtoupper(Str::random(5)),
            'amount'         => $amount,
            'payment_status' => 'waiting',
            'payment_date'   => $data['payment_date'],
            'proof_image'    => $path,
            'payment_method' => $data['payment_method']
        ]);

        if ($amount > $order->total_price) {
            return back()
                ->with('error', 'Jumlah pembayaran melebihi total harga.')
                ->withInput();
        }


        $order->update(['order_status' => 'pending']);

        return redirect('/')
            ->with('payment_success', true)
            ->with('payment_id', $payment->id);
    }   


    /**
     * Cetak Laporan PDF (Admin)
     */
    public function printPayment(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = Payment::with('order');

        if ($startDate && $endDate) {
            $query->whereBetween('payment_date', [$startDate, $endDate]);
        }

        $payments = $query->latest()->get();

        $pdf = Pdf::loadView('pdf.payment', [
            'payments' => $payments,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        $pdf->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-pembayaran-' . date('Ymd') . '.pdf');
    }

    public function receipt(Payment $payment)
    {
        $payment->load('order');

        if ($payment->order->customer_id !== Auth::id()) {
            abort(403);
        }

        return view('payment-receipt', compact('payment'));
    }


}