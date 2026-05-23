<?php

namespace App\Filament\Widgets;

use Filament\Actions\BulkActionGroup;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class LatestOrders extends TableWidget
{
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => \App\Models\Order::query()->latest()->limit(5))
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('order_code')
                    ->label('ID Pesanan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                \Filament\Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'confirmed' => 'info',
                        'production' => 'primary',
                        'ready' => 'success',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('payment_status')
                    ->label('Pembayaran')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        'paid' => 'success',
                        default => 'gray',
                    })
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
            ])
            ->recordActions([
                \Filament\Actions\Action::make('updateStatus')
                    ->label('Update Progress')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\Select::make('status')
                            ->options(\App\Filament\Resources\Orders\OrderResource::statusOptions())
                            ->default(fn (\App\Models\Order $record) => $record->status)
                            ->required(),
                        \Filament\Forms\Components\Textarea::make('note')
                            ->label('Catatan Perubahan')
                            ->rows(2),
                    ])
                    ->action(function (\App\Models\Order $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                        $record->statusHistories()->create([
                            'status' => $data['status'],
                            'note' => $data['note'],
                            'changed_by' => \Illuminate\Support\Facades\Auth::id(),
                        ]);
                    }),
                \Filament\Actions\Action::make('view')
                    ->label('View')
                    ->url(fn (\App\Models\Order $record): string => \App\Filament\Resources\Orders\OrderResource::getUrl('view', ['record' => $record]))
                    ->icon('heroicon-o-eye'),
            ]);
    }
}
