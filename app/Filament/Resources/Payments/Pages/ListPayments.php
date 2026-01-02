<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use Filament\Actions; // Import Actions bawaan Page
use Filament\Resources\Pages\ListRecords;
use Filament\Forms\Components\DatePicker;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // 1. Tombol Create Bawaan
            Actions\CreateAction::make(),

            // 2. Tombol Cetak Laporan
            Actions\Action::make('cetak_laporan')
                ->label('Cetak PDF')
                ->icon('heroicon-o-printer')
                ->color('success') // Warna Hijau
                ->form([
                    DatePicker::make('start_date')
                        ->label('Dari Tanggal')
                        ->required()
                        ->default(now()->startOfMonth()),
                    
                    DatePicker::make('end_date')
                        ->label('Sampai Tanggal')
                        ->required()
                        ->default(now()->endOfMonth()),
                ])
                ->action(function (array $data) {
                    // Redirect ke Controller Payment
                    return redirect()->route('print.payment', [
                        'start_date' => $data['start_date'],
                        'end_date' => $data['end_date'],
                    ]);
                }),
        ];
    }
}