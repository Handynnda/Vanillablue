<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
    
    protected function afterCreate(): void
    {
        // Opsional: jika langsung membuat payment berstatus confirmed, sinkronkan order
        $payment = $this->record;
        if ($payment && $payment->payment_status === 'confirmed') {
            $order = $payment->order;
            if ($order && $order->order_status === 'pending') {
                $order->order_status = 'confirmed';
                $order->save();
            }
        }
    }
}
