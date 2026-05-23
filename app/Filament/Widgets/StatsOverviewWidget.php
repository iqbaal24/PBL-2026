<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseStatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseStatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Revenue', 'Rp ' . number_format(\App\Models\Order::where('payment_status', 'paid')->sum('total_price'), 0, ',', '.'))
                ->description('Total pendapatan dari pesanan yang sudah dibayar')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            Stat::make('Total Orders', \App\Models\Order::count())
                ->description('Total keseluruhan pesanan')
                ->descriptionIcon('heroicon-m-shopping-cart'),
            Stat::make('Active Orders', \App\Models\Order::whereNotIn('status', ['completed', 'cancelled'])->count())
                ->description('Pesanan yang sedang diproses')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),
        ];
    }
}
