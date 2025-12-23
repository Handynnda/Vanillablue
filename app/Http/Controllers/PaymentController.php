<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class PaymentController extends Controller
{
    public function create($orderId)
    {
        $order = Order::findOrFail($orderId);

        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }
        return view('payment', compact('order'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id'        => 'required|exists:orders,id',
            'amount'          => 'required|numeric|min:0',
            'payment_date'    => 'required|date',
            'payment_method'  => 'required|in:bank_a,bank_b,bank_c',
            'proof_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $order = Order::findOrFail($data['order_id']);

        if ($order->customer_id !== Auth::id()) {
            abort(403);
        }

        $path = null;
        if ($request->hasFile('proof_image')) {
            try {
                $file = $request->file('proof_image');
                $extension = strtolower($file->getClientOriginalExtension());
                $basename = uniqid('pay_');

                $stored = $file->storeAs(
                    'payments', 
                    $basename.'.'.$extension, 
                    'cloudinary'
                );

                $info = pathinfo($stored);
                $dirname = isset($info['dirname']) ? str_replace('\\', '/', $info['dirname']) : '';
                $dirname = ($dirname === '.' ? '' : trim($dirname, '/'));
                $filename = $info['filename'] ?? pathinfo($stored, PATHINFO_FILENAME);
                $publicId = ($dirname ? $dirname.'/' : '').$filename;
                try {
                    $asset = Cloudinary::adminApi()->asset($publicId, ['resource_type' => 'image']);
                    $secure = $asset->offsetGet('secure_url');
                    $path = $secure ?: $stored;
                } catch (\Throwable $e) {
                    // Fallback bangun URL manual jika adminApi gagal
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

       return redirect('/')->with('success', 'Pembayaran berhasil dikirim, menunggu verifikasi.');

    }
}
