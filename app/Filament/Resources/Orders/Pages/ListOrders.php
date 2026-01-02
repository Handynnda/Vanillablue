<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions; // Import actions bawaan halaman
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. Tombol Bawaan "Create" (Buat Baru)
            Actions\CreateAction::make(),

            // 2. Tombol Custom "Cetak Laporan"
            Actions\Action::make('cetak_laporan')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->color('success')
                ->form([
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal')
                        ->required()
                        ->default(now()->startOfMonth()),
                    
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal')
                        ->required()
                        ->default(now()->endOfMonth()),

                    Select::make('status')
                        ->label('Status Order')
                        ->options([
                            'all' => 'Semua Status',
                            'paid' => 'Paid (Lunas)',
                            'unpaid' => 'Unpaid (Belum Lunas)',
                            'pending' => 'Pending',
                        ])
                        ->default('all')
                        ->required(),
                ])
                ->action(function (array $data) {
                    // Redirect ke Controller Cetak
                    return redirect()->route('print.order', [
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                        'status' => $data['status'],
                    ]);
                }),
        ];
    }
}