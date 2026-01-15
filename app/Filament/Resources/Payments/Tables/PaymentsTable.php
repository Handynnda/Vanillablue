<?php

namespace App\Filament\Resources\Payments\Tables;

use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // Urutkan data terbaru terlebih dahulu
            ->modifyQueryUsing(fn ($query) => $query->orderByDesc('created_at'))
            ->columns([
                TextColumn::make('order_id')
                    ->label('Order ID')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->money('IDR', true)
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable()
                    ->searchable(),
                TextColumn::make('payment_status')
                    ->label('Status')
                    ->badge()
                    ->colors([
                        'warning' => 'waiting',
                        'success' => 'confirmed',
                        'danger' => 'rejected',
                    ])
                    ->searchable(),
                TextColumn::make('payment_method')
                    ->label('Metode')
                    ->formatStateUsing(function ($state) {
                        if (str_starts_with($state, 'midtrans_')) {
                            $method = str_replace('midtrans_', '', $state);
                            return 'Midtrans (' . ucfirst($method) . ')';
                        }
                        return match($state) {
                            'bank_a' => 'BCA',
                            'bank_b' => 'DANA',
                            'bank_c' => 'BRI',
                            'midtrans' => 'Midtrans',
                            default => ucfirst($state),
                        };
                    })
                    ->searchable(),
                TextColumn::make('midtrans_transaction_status')
                    ->label('Status Midtrans')
                    ->badge()
                    ->colors([
                        'success' => fn($state) => in_array($state, ['capture', 'settlement']),
                        'warning' => fn($state) => $state === 'pending',
                        'danger' => fn($state) => in_array($state, ['deny', 'cancel', 'expire']),
                    ])
                    ->formatStateUsing(fn($state) => $state ? ucfirst($state) : '-')
                    ->toggleable(isToggledHiddenByDefault: false),
                TextColumn::make('midtrans_transaction_id')
                    ->label('Midtrans ID')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('payment_date')
                    ->date()
                    ->sortable()
                    ->searchable(),
                ImageColumn::make('proof_image')
                    ->label('Bukti')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ]);

    }
}