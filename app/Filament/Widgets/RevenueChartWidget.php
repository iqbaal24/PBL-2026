<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class RevenueChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;
    protected ?string $heading = 'Grafik Pendapatan Bulanan';

    protected function getData(): array
    {
        $orders = \App\Models\Order::where('payment_status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->get();
            
        $revenues = array_fill(1, 12, 0);
        foreach ($orders as $order) {
            $month = (int)$order->created_at->format('m');
            $revenues[$month] += $order->total_price;
        }

        $labels = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => array_values($revenues),
                    'backgroundColor' => '#10b981', // emerald
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
