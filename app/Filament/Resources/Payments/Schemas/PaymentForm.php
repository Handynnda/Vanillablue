<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Placeholder;
use Illuminate\Support\HtmlString;
use Carbon\Carbon;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components(function (Schema $schema) {
            $context = method_exists($schema, 'getContext') ? $schema->getContext() : null;

            // =========================
            // CREATE PAYMENT (OFFLINE)
            // =========================
            if ($context === 'create') {
                return [
                    Placeholder::make('order_id')
                        ->label('Order ID')
                        ->content(fn ($record) => $record?->order_id ?? '-'),

                    TextInput::make('amount')
                        ->label('Jumlah')
                        ->numeric()
                        ->required(),

                    Select::make('payment_status')
                        ->label('Status Pembayaran')
                        ->options([
                            'waiting' => 'Waiting',
                            'confirmed' => 'Confirmed',
                            'rejected' => 'Rejected',
                        ])
                        ->default('waiting')
                        ->required(),

                    TextInput::make('payment_method')
                        ->label('Metode Pembayaran')
                        ->required(),

                    DatePicker::make('payment_date')
                        ->label('Tanggal Pembayaran')
                        ->required(),

                    Placeholder::make('proof_image_preview')
                        ->label('Bukti Pembayaran')
                        ->content(fn ($get) => $get('proof_image')
                            ? new HtmlString(
                                '<div style="margin-top:8px">
                                    <a href="'.e($get('proof_image')).'" target="_blank" rel="noopener">
                                        <img src="'.e($get('proof_image')).'" style="max-width:100%;border-radius:8px">
                                    </a>
                                </div>'
                            )
                            : new HtmlString('<span class="text-gray-500">Belum ada bukti.</span>')
                        ),
                ];
            }

            // =========================
            // EDIT PAYMENT
            // =========================
            return [
                Placeholder::make('order_id')
                    ->label('Order ID')
                    ->content(fn ($record) => $record?->order_id ?? '-'),

                Placeholder::make('amount')
                    ->label('Jumlah')
                    ->content(fn ($record) => $record?->amount !== null
                        ? number_format((float) $record->amount, 0, ',', '.')
                        : '-'
                    ),

                Placeholder::make('payment_method')
                    ->label('Metode Pembayaran')
                    ->content(fn ($record) => $record->payment_method ?? '-'),

                Placeholder::make('payment_date')
                    ->label('Tanggal Pembayaran')
                    ->content(function ($record) {
                        $date = $record?->payment_date;
                        if ($date instanceof Carbon) {
                            return $date->format('d M Y');
                        }
                        if (is_string($date) && !empty($date)) {
                            try {
                                return Carbon::parse($date)->format('d M Y');
                            } catch (\Throwable $th) {
                                return $date; // fallback to raw string
                            }
                        }
                        return '-';
                    }),

                Select::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'waiting' => 'Waiting',
                        'confirmed' => 'Confirmed',
                        'rejected' => 'Rejected',
                    ])
                    ->required(),

                Placeholder::make('proof_image_preview')
                    ->label('Bukti Pembayaran')
                    ->content(fn ($record) => $record?->proof_image
                        ? new HtmlString(
                            '<div style="margin-top:8px">
                                <a href="'.e($record->proof_image).'" target="_blank" rel="noopener">
                                    <img src="'.e($record->proof_image).'" style="max-width:100%;border-radius:8px">
                                </a>
                            </div>'
                        )
                        : new HtmlString('<span class="text-gray-500">Belum ada bukti.</span>')
                    ),
            ];
        });
    }
}
