<?php

namespace App\Filament\Resources\Reviews\Tables;

use App\Models\Review;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ReviewTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->icon('heroicon-m-star')
                    ->color('warning')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('comment')
                    ->label('Komentar')
                    ->limit(50)
                    ->searchable()
                    ->wrap()
                    ->tooltip(fn (Review $record): string => $record->comment),
                TextColumn::make('product.name')
                    ->label('Produk')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('order.order_code')
                    ->label('ID Pesanan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ToggleColumn::make('is_visible')
                    ->label('Tampilkan'),
                TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                TernaryFilter::make('is_visible'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
