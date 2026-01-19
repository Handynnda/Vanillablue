<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
use Carbon\Carbon;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components(function (Schema $schema) {
                $context = method_exists($schema, 'getContext') ? $schema->getContext() : null;

                // ==========================
                // CREATE ORDER (full form)
                // ==========================
                if ($context === 'create') {
                    return [
                        Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Select::make('bundling_id')
                            ->label('Paket')
                            ->relationship('bundling', 'name_bundling')
                            ->searchable()
                            ->preload()
                            ->required(),
                        DatePicker::make('book_date')
                            ->required(),
                        TimePicker::make('book_time')
                            ->required(),
                        Select::make('location')
                            ->options(['indoor' => 'Indoor', 'outdoor' => 'Outdoor'])
                            ->default('indoor')
                            ->required(),
                        TextInput::make('note')
                            ->default(null),
                        Select::make('order_status')
                            ->options(['confirmed' => 'Confirmed', 'completed' => 'Completed', 'pending' => 'Pending', 'failed' => 'Failed'])
                            ->default('pending')
                            ->required(),
                        TextInput::make('total_price')
                            ->required()
                            ->numeric()
                            ->prefix('IDR'),
                        TextInput::make('sum_order')
                            ->required()
                            ->numeric()
                            ->default(1),
                    ];
                }

                // ==========================
                // EDIT ORDER (mostly readonly)
                // ==========================
                return [
                    // Readonly fields using Placeholder
                    Placeholder::make('id')
                        ->label('Order ID')
                        ->content(fn ($record) => $record?->id ?? '-'),

                    Placeholder::make('customer_name')
                        ->label('Customer')
                        ->content(fn ($record) => $record?->customer?->name ?? '-'),

                    Placeholder::make('bundling_name')
                        ->label('Paket')
                        ->content(fn ($record) => $record?->bundling?->name_bundling ?? '-'),

                    Placeholder::make('book_date_display')
                        ->label('Tanggal Booking')
                        ->content(fn ($record) => $record?->book_date 
                            ? Carbon::parse($record->book_date)->translatedFormat('d F Y')
                            : '-'),

                    Placeholder::make('book_time_display')
                        ->label('Jam Booking')
                        ->content(fn ($record) => $record?->book_time 
                            ? Carbon::parse($record->book_time)->format('H:i') . ' WIB'
                            : '-'),

                    Placeholder::make('location_display')
                        ->label('Lokasi')
                        ->content(fn ($record) => ucfirst($record?->location ?? '-')),

                    Placeholder::make('note_display')
                        ->label('Catatan')
                        ->content(fn ($record) => $record?->note ?? '-'),

                    Placeholder::make('total_price_display')
                        ->label('Total Harga')
                        ->content(fn ($record) => $record?->total_price 
                            ? 'Rp ' . number_format($record->total_price, 0, ',', '.')
                            : '-'),

                    Placeholder::make('sum_order_display')
                        ->label('Jumlah Order')
                        ->content(fn ($record) => $record?->sum_order ?? 1),

                    // Editable: Status Order
                    Select::make('order_status')
                        ->label('Status Order')
                        ->options([
                            'pending' => 'Pending',
                            'confirmed' => 'Confirmed',
                            'completed' => 'Completed',
                            'failed' => 'Failed',
                        ])
                        ->required()
                        ->live(), // Realtime update when status changes

                    // Editable: Google Drive Link (only visible when completed)
                    TextInput::make('google_drive_link')
                        ->label('Link Google Drive (Hasil Foto)')
                        ->placeholder('https://drive.google.com/...')
                        ->url()
                        ->helperText('Isi link Google Drive hasil foto untuk customer. Link akan muncul di history pesanan customer.')
                        ->visible(fn ($get) => $get('order_status') === 'completed'),
                ];
            });
    }
}
