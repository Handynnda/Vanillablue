<?php

namespace App\Filament\Widgets;

use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pesanan', '100')
                ->description('Semua pesanan yang tercatat')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('primary'),

            Stat::make('Pending Pesanan', '20')
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-clock')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('warning'),

            Stat::make('Pendapatan', 'Rp ' . number_format('3000000', 0, ',', '.'))
                ->description('Pendapatan bulan ini')
                ->descriptionIcon('heroicon-m-banknotes')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),
        ];
    }
}
