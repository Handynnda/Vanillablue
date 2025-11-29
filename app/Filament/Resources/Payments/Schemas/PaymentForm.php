<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;

use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('order_id')
                    ->required()
                    ->numeric(),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Select::make('payment_status')
                    ->options(['waiting' => 'Waiting', 'confirmed' => 'Confirmed', 'rejected' => 'Rejected'])
                    ->default('waiting')
                    ->required(),
                TextInput::make('payment_method')
                    ->default(null),
                DatePicker::make('payment_date')
                    ->required(),
                Placeholder::make('proof_image_preview')
                    ->label('Bukti Pembayaran')
                    ->content(fn ($get) => $get('proof_image')
                        ? new HtmlString('<div style="margin-top:8px"><a href="'.e($get('proof_image')).'" target="_blank" rel="noopener"><img src="'.e($get('proof_image')).'" alt="Bukti Pembayaran" style="max-width:100%;height:auto;border-radius:8px;box-shadow:0 4px 10px rgba(0,0,0,.1)"></a></div>')
                        : new HtmlString('<span class="text-gray-500">Belum ada bukti.</span>')
                ),           
            ]);
    }
}
