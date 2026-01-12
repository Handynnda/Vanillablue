<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Urutkan data terbaru terlebih dahulu & eager load payment untuk hitung sisa
            ->modifyQueryUsing(fn ($query) => $query->with('payment')->orderByDesc('created_at'))
            ->columns([
                TextColumn::make('id')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('customer.name')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('bundling.name_bundling')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('phone')
                    ->label('No. WA')
                    ->searchable(),

                TextColumn::make('book_date')
                    ->date()
                    ->sortable(),

                TextColumn::make('book_time')
                    ->time()
                    ->sortable(),

                TextColumn::make('location')
                    ->badge()
                    ->searchable(),

                TextColumn::make('note')
                    ->searchable(),

                TextColumn::make('order_status')
                    ->badge()
                    ->colors([
                        'info'    => 'confirmed',
                        'success' => 'completed',
                        'warning' => 'pending',
                        'danger'  => 'failed',
                    ])
                    ->searchable(),

                TextColumn::make('total_price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('remaining_amount')
                    ->label('Sisa Pembayaran')
                    ->state(function (\App\Models\Order $record) {
                        // Jika order sudah completed, sisa otomatis nol
                        if ($record->order_status === 'completed') {
                            return 0.0;
                        }

                        $total = (float) ($record->total_price ?? 0);
                        $dp = 0.0;
                        // Kurangi hanya pembayaran yang sudah dikonfirmasi
                        if ($record->payment && ($record->payment->payment_status === 'confirmed')) {
                            $dp = (float) ($record->payment->amount ?? 0);
                        }
                        $remaining = max(0, $total - $dp);
                        return $remaining;
                    })
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format((float) $state, 0, ',', '.'))
                    // Tampilkan merah jika masih ada sisa, hijau jika nol
                    ->color(fn ($state) => ((float) $state) > 0 ? 'danger' : 'success'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ]);

    }
}
