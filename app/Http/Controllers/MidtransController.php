<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Generate Snap Token for payment
     */
    public function getSnapToken(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::with('bundling')->findOrFail($request->order_id);

        // Ensure user owns this order
        if ($order->customer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Check if order already has a completed payment
        if ($order->payment && $order->payment->payment_status === 'confirmed') {
            return response()->json(['error' => 'Order sudah dibayar'], 400);
        }

        $user = Auth::user();

        // Build transaction details
        $transactionDetails = [
            'order_id' => $order->id, // Uses existing ORD prefix
            'gross_amount' => (int) $order->total_price,
        ];

        // Item details from bundling
        $itemDetails = [
            [
                'id' => $order->bundling_id,
                'price' => (int) $order->total_price,
                'quantity' => 1,
                'name' => substr($order->bundling->name_bundling, 0, 50), // Max 50 chars
            ]
        ];

        // Customer details from logged-in user
        $customerDetails = [
            'first_name' => $user->name,
            'email' => $user->email,
            'phone' => $order->phone ?? $user->phone ?? '',
        ];

        // Build transaction params
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
            'callbacks' => [
                // Finish URL for redirect-based payments (DANA, etc.)
                'finish' => route('midtrans.finish', ['order_id' => $order->id]),
            ],
            'expiry' => [
                'start_time' => date('Y-m-d H:i:s O'),
                'unit' => config('midtrans.expiry_unit'),
                'duration' => config('midtrans.expiry_duration'),
            ],
        ];

        // Only filter payment methods if specified in config
        $enabledPayments = config('midtrans.enabled_payments');
        if (!empty($enabledPayments)) {
            $params['enabled_payments'] = $enabledPayments;
        }

        try {
            $snapToken = Snap::getSnapToken($params);

            // Create or update payment record with snap token
            $payment = Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'amount' => $order->total_price,
                    'payment_status' => 'waiting',
                    'payment_date' => now()->toDateString(),
                    'payment_method' => 'midtrans',
                    'snap_token' => $snapToken,
                ]
            );

            return response()->json([
                'snap_token' => $snapToken,
                'client_key' => config('midtrans.client_key'),
            ]);

        } catch (\Exception $e) {
            Log::error('Midtrans Snap Token Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat transaksi: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Handle Midtrans notification callback (webhook)
     */
    public function handleNotification(Request $request)
    {
        try {
            // Get notification from Midtrans
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status ?? null;
            $transactionId = $notification->transaction_id ?? null;
            $paymentType = $notification->payment_type ?? null;

            Log::info('Midtrans Notification:', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'transaction_id' => $transactionId,
                'payment_type' => $paymentType,
            ]);

            // Find the order
            $order = Order::find($orderId);
            if (!$order) {
                Log::warning('Midtrans Notification: Order not found - ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
            }

            // Find or create payment
            $payment = Payment::where('order_id', $orderId)->first();
            if (!$payment) {
                $payment = new Payment();
                $payment->order_id = $orderId;
                $payment->amount = $order->total_price;
                $payment->payment_date = now()->toDateString();
            }

            // Update payment with Midtrans data
            $payment->midtrans_transaction_id = $transactionId;
            $payment->midtrans_transaction_status = $transactionStatus;
            $payment->payment_method = 'midtrans_' . ($paymentType ?? 'unknown');

            // Map Midtrans status to our status
            $paymentStatus = 'waiting';
            $orderStatus = 'pending';

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                // For credit card: capture with fraud_status either accept or challenge
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'accept') {
                        $paymentStatus = 'confirmed';
                        $orderStatus = 'confirmed';
                    } elseif ($fraudStatus == 'challenge') {
                        $paymentStatus = 'waiting';
                        $orderStatus = 'pending';
                    }
                } else {
                    // settlement
                    $paymentStatus = 'confirmed';
                    $orderStatus = 'confirmed';
                }
            } elseif ($transactionStatus == 'pending') {
                $paymentStatus = 'waiting';
                $orderStatus = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $paymentStatus = 'rejected';
                $orderStatus = 'failed';
            }

            $payment->payment_status = $paymentStatus;
            $payment->save();

            // Update order status
            $order->order_status = $orderStatus;
            $order->save();

            Log::info('Midtrans Notification Processed:', [
                'order_id' => $orderId,
                'payment_status' => $paymentStatus,
                'order_status' => $orderStatus,
            ]);

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Update payment status from client-side callback (fallback for webhook)
     * Called when Snap returns success but webhook might not arrive
     */
    public function updatePaymentStatus(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'transaction_status' => 'required|string',
            'transaction_id' => 'nullable|string',
            'payment_type' => 'nullable|string',
        ]);

        $orderId = $request->order_id;
        $transactionStatus = $request->transaction_status;
        $transactionId = $request->transaction_id;
        $paymentType = $request->payment_type;

        // Verify user owns this order
        $order = Order::find($orderId);
        if (!$order || $order->customer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Find payment
        $payment = Payment::where('order_id', $orderId)->first();
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        // Only update if current status is still waiting (don't overwrite webhook updates)
        if ($payment->payment_status !== 'waiting') {
            return response()->json([
                'status' => 'already_updated',
                'payment_status' => $payment->payment_status,
                'order_status' => $order->order_status,
            ]);
        }

        // Update Midtrans data
        if ($transactionId) {
            $payment->midtrans_transaction_id = $transactionId;
        }
        $payment->midtrans_transaction_status = $transactionStatus;
        if ($paymentType) {
            $payment->payment_method = 'midtrans_' . $paymentType;
        }

        // Map status
        $paymentStatus = 'waiting';
        $orderStatus = 'pending';

        if (in_array($transactionStatus, ['capture', 'settlement'])) {
            $paymentStatus = 'confirmed';
            $orderStatus = 'confirmed';
        } elseif ($transactionStatus == 'pending') {
            $paymentStatus = 'waiting';
            $orderStatus = 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
            $paymentStatus = 'rejected';
            $orderStatus = 'failed';
        }

        $payment->payment_status = $paymentStatus;
        $payment->save();

        $order->order_status = $orderStatus;
        $order->save();

        Log::info('Payment status updated from client callback:', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'payment_status' => $paymentStatus,
            'order_status' => $orderStatus,
        ]);

        return response()->json([
            'status' => 'success',
            'payment_status' => $paymentStatus,
            'order_status' => $orderStatus,
        ]);
    }

    /**
     * Handle finish redirect from Midtrans (for redirect-based payments like DANA)
     * Called when user completes payment and is redirected back from payment provider
     */
    public function handleFinish(Request $request)
    {
        $orderId = $request->get('order_id');
        $transactionStatus = $request->get('transaction_status');
        $statusCode = $request->get('status_code');
        $transactionId = $request->get('transaction_id');

        Log::info('Midtrans Finish Redirect:', [
            'order_id' => $orderId,
            'transaction_status' => $transactionStatus,
            'status_code' => $statusCode,
            'all_params' => $request->all(),
        ]);

        if (!$orderId) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan');
        }

        // Find order and payment
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan');
        }

        $payment = Payment::where('order_id', $orderId)->first();
        $paymentType = null;

        // Try to get actual status from Midtrans API
        try {
            $status = \Midtrans\Transaction::status($orderId);
            $transactionStatus = $status->transaction_status ?? $transactionStatus;
            $transactionId = $status->transaction_id ?? $transactionId;
            $paymentType = $status->payment_type ?? null;

            Log::info('Midtrans Transaction Status from API:', [
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'transaction_id' => $transactionId,
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to get Midtrans transaction status: ' . $e->getMessage());
            // For DANA and other redirect payments, if status_code is 200, assume success
            if ($statusCode == '200' || $statusCode == 200) {
                $transactionStatus = 'settlement';
                Log::info('Assuming settlement based on status_code 200');
            }
        }

        // Update payment record (moved outside try block)
        if ($payment && $transactionStatus) {
            if ($transactionId) {
                $payment->midtrans_transaction_id = $transactionId;
            }
            $payment->midtrans_transaction_status = $transactionStatus;
            if ($paymentType) {
                $payment->payment_method = 'midtrans_' . $paymentType;
            }

            // Map status
            if (in_array($transactionStatus, ['capture', 'settlement'])) {
                $payment->payment_status = 'confirmed';
                $order->order_status = 'confirmed';
            } elseif ($transactionStatus == 'pending') {
                $payment->payment_status = 'waiting';
                $order->order_status = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'cancel', 'expire'])) {
                $payment->payment_status = 'rejected';
                $order->order_status = 'failed';
            }

            $payment->save();
            $order->save();

            Log::info('Payment status updated from finish redirect:', [
                'order_id' => $orderId,
                'payment_status' => $payment->payment_status,
                'order_status' => $order->order_status,
            ]);
        }

        // Redirect to home with success popup
        return redirect()->route('home', [
            'payment_success' => 'true',
            'payment_id' => $orderId
        ]);
    }
}

