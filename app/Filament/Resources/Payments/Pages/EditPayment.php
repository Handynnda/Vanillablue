<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\Order;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Jika payment dikonfirmasi, sinkronkan status order dari pending -> confirmed
        $payment = $this->record; // Payment yang sedang diedit
        if ($payment && $payment->payment_status === 'confirmed') {
            $order = $payment->order;
            if ($order && $order->order_status === 'pending') {
                $order->order_status = 'confirmed';
                $order->save();
            }
        }
    }
}
