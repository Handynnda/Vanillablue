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
                        'danger'  => 'failed',
                    ])
                    ->searchable(),

                TextColumn::make('total_price')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->sortable(),

                TextColumn::make('sum_order')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([

                Action::make('print_pdf')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->action(function () {
                    $orders = Order::with(['customer', 'bundling'])->get();
            
                    return response()->streamDownload(
                        function () use ($orders) {
                            echo Pdf::loadView('pdf.orders', [
                                'orders' => $orders,
                            ])->output();
                        },
                        'laporan-order.pdf'
                    );
                }),
            
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
