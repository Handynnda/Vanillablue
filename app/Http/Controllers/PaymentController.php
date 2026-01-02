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
            'amount'          => 'required|numeric|min:0',
            'payment_date'    => 'required|date',
            'payment_method'  => 'required|in:bank_a,bank_b,bank_c',
            'proof_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $order = Order::findOrFail($data['order_id']);

        // Pastikan ID User tidak 0
        if (!Auth::check() || Auth::id() === 0) {
            return redirect()->route('login')->with('error', 'Identitas user tidak dikenali.');
        }

        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $path = null;
        if ($request->hasFile('proof_image')) {
            try {
                $file = $request->file('proof_image');
                $extension = strtolower($file->getClientOriginalExtension());
                $basename = uniqid('pay_');

                // Menggunakan disk 'cloudinary' sesuai settingan Anda yang berhasil sebelumnya
                $stored = $file->storeAs(
                    'payments', 
                    $basename.'.'.$extension, 
                    'cloudinary'
                );

                // Logika pengambilan URL Secure dari Cloudinary
                $info = pathinfo($stored);
                $dirname = isset($info['dirname']) ? str_replace('\\', '/', $info['dirname']) : '';
                $dirname = ($dirname === '.' ? '' : trim($dirname, '/'));
                $filename = $info['filename'] ?? pathinfo($stored, PATHINFO_FILENAME);
                $publicId = ($dirname ? $dirname.'/' : '').$filename;
                
                try {
                    $asset = Cloudinary::adminApi()->asset($publicId, ['resource_type' => 'image']);
                    $path = $asset->offsetGet('secure_url');
                } catch (\Throwable $e) {
                    $cloudName = config('cloudinary.cloud_name');
                    $path = $cloudName ? "https://res.cloudinary.com/{$cloudName}/image/upload/{$publicId}.{$extension}" : $stored;
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Upload bukti gagal: ' . $e->getMessage());
            }
        }

        $paymentCode = 'PYM-' . strtoupper(Str::random(5));

        Payment::create([
            'order_id'       => $order->id,
            'payment_code'   => $paymentCode,
            'amount'         => $data['amount'],
            'payment_status' => 'waiting',
            'payment_date'   => $data['payment_date'],
            'proof_image'    => $path,
            'payment_method' => $data['payment_method']
        ]);

        // Update status order menjadi pending
        $order->update(['order_status' => 'pending']);

        return redirect('/')->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi.');
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
}