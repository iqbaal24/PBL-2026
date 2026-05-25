<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class TopProductsWidget extends TableWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'Leaderboard Produk Terlaris';
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Product::query()
                    ->withSum('orderItems', 'quantity')
                    ->orderBy('order_items_sum_quantity', 'desc')
                    ->whereHas('orderItems') // Hanya tampilkan produk yang pernah dipesan
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Produk')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('order_items_sum_quantity')
                    ->label('Total Terjual')
                    ->sortable()
                    ->suffix(' unit')
                    ->alignCenter()
                    ->color('success')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('base_price')
                    ->label('Harga Dasar')
                    ->money('IDR', locale: 'id'),
            ])
            ->paginated(false);
    }
}
