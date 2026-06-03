<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class OrderTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_code')
                    ->label('ID')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                TextColumn::make('customer_name')
                    ->label('Pelanggan')
                    ->description(fn (Order $record): string => $record->customer_phone ?? '')
                    ->searchable(['customer_name', 'customer_phone', 'order_code'])
                    ->sortable(),
                TextColumn::make('items_summary')
                    ->label('Pesanan')
                    ->getStateUsing(fn (Order $record): string => $record->items->map(fn ($item) => "{$item->quantity}x {$item->product_name}")->join(', '))
                    ->limit(30)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
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
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'confirmed' => 'heroicon-m-check-circle',
                        'production' => 'heroicon-m-cog-6-tooth',
                        'ready' => 'heroicon-m-truck',
                        'completed' => 'heroicon-m-check-badge',
                        'cancelled' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),
                TextColumn::make('payment_status')
                    ->label('Bayar')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'unpaid' => 'danger',
                        'partial' => 'warning',
                        'paid' => 'success',
                        default => 'gray',
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'unpaid' => 'heroicon-m-x-circle',
                        'partial' => 'heroicon-m-exclamation-circle',
                        'paid' => 'heroicon-m-check-circle',
                        default => 'heroicon-m-question-mark-circle',
                    })
                    ->sortable(),
                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->alignment('right'),
                TextColumn::make('deadline')
                    ->date('d/m/y')
                    ->sortable()
                    ->color(fn (Order $record): string => $record->deadline && $record->deadline->isPast() && $record->status !== 'completed' ? 'danger' : 'gray'),
                TextColumn::make('admin.name')
                    ->label('Admin')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')->options(OrderResource::statusOptions()),
                SelectFilter::make('payment_status')->options(OrderResource::paymentStatusOptions()),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                \Filament\Actions\Action::make('whatsapp')
                    ->label('WhatsApp')
                    ->icon('heroicon-m-chat-bubble-left-right')
                    ->color('success')
                    ->url(fn (Order $record): string => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->customer_phone) . "?text=" . urlencode("Halo {$record->customer_name}, kami dari PBL Store ingin menginformasikan mengenai pesanan Anda #{$record->order_code}..."))
                    ->openUrlInNewTab(),
                \Filament\Actions\Action::make('updateStatus')
                    ->label('Update Progress')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\Select::make('status')
                            ->options(OrderResource::statusOptions())
                            ->default(fn (Order $record) => $record->status)
                            ->required(),
                        \Filament\Forms\Components\Textarea::make('note')
                            ->label('Catatan Perubahan')
                            ->rows(2),
                    ])
                    ->action(function (Order $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                        $record->statusHistories()->create([
                            'status' => $data['status'],
                            'note' => $data['note'],
                            'changed_by' => Auth::id(),
                        ]);
                    }),
                ViewAction::make()
                    ->label('View')
                    ->icon('heroicon-m-eye')
                    ->color('gray'),
                EditAction::make()->slideOver(),
                DeleteAction::make()
                    ->modalDescription('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('updateBulkStatus')
                        ->label('Update Status Massal')
                        ->icon('heroicon-m-arrow-path')
                        ->color('warning')
                        ->form([
                            \Filament\Forms\Components\Select::make('status')
                                ->options(OrderResource::statusOptions())
                                ->required(),
                            \Filament\Forms\Components\Textarea::make('note')
                                ->label('Catatan (Opsional)')
                                ->rows(2),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            $records->each(function (Order $record) use ($data) {
                                $record->update(['status' => $data['status']]);
                                $record->statusHistories()->create([
                                    'status' => $data['status'],
                                    'note' => $data['note'] ?? 'Bulk update',
                                    'changed_by' => Auth::id(),
                                ]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
