<?php

namespace App\Filament\Resources\Orders\Tables;

use Dom\Text;
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
                    'warning' => 'unpaid',
                    'success' => 'paid',
                    'danger' => 'failed',
                    ])
                    ->searchable(),
                TextColumn::make('total_price')
                    ->money('IDR', true)
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),
                TextColumn::make('sum_order')
                    ->numeric()
                    ->sortable()
                    ->searchable(),
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
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
