<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class OrdersChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Grafik Pesanan Bulanan';

    protected function getData(): array
    {
        $orders = \App\Models\Order::whereYear('created_at', date('Y'))->get();
        $counts = array_fill(1, 12, 0);
        foreach ($orders as $order) {
            $month = (int)$order->created_at->format('m');
            $counts[$month]++;
        }

        $labels = [];
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('M', mktime(0, 0, 0, $i, 1));
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pesanan ' . date('Y'),
                    'data' => array_values($counts),
                    'fill' => 'start',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
