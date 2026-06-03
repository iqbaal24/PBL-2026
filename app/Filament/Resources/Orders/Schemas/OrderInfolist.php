<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class OrderInfolist
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer Info')
                ->schema([
                    TextEntry::make('order_code')->copyable(),
                    TextEntry::make('customer_name'),
                    TextEntry::make('customer_phone')->label('WhatsApp Number')->copyable(),
                    TextEntry::make('deadline')->date()->placeholder('-'),
                    TextEntry::make('customer_address')->placeholder('-')->columnSpanFull(),
                    TextEntry::make('admin.name')->label('Admin')->placeholder('-'),
                    TextEntry::make('created_at')->dateTime(),
                ])
                ->columns(2),
            Section::make('Order Items')
                ->schema([
                    RepeatableEntry::make('items')
                        ->schema([
                            TextEntry::make('product_name')->label('Product'),
                            TextEntry::make('specification')->label('Specification')->placeholder('-')->columnSpanFull(),
                            TextEntry::make('quantity'),
                            TextEntry::make('unit_price')->money('IDR')->placeholder('-'),
                            TextEntry::make('subtotal')->money('IDR')->placeholder('-'),
                            TextEntry::make('general_notes')->label('Admin Item Notes')->placeholder('-')->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->placeholder('No items.'),
                ]),
            Section::make('Payment')
                ->schema([
                    TextEntry::make('total_price')->money('IDR')->placeholder('-'),
                    TextEntry::make('paid_amount')->money('IDR'),
                    TextEntry::make('payment_status')->badge(),
                    TextEntry::make('status')->badge(),
                ])
                ->columns(4),
            Section::make('Files')
                ->schema([
                    RepeatableEntry::make('files')
                        ->schema([
                            TextEntry::make('file_name')->label('File name')->placeholder('-'),
                            TextEntry::make('file_type')->badge(),
                            TextEntry::make('orderItem.product_name')->label('Related item')->placeholder('-'),
                            TextEntry::make('uploader.name')->label('Uploaded by')->placeholder('-'),
                            TextEntry::make('file_path')
                                ->label('Open file')
                                ->url(fn (?string $state): ?string => $state ? Storage::disk('public')->url($state) : null)
                                ->openUrlInNewTab()
                                ->placeholder('-'),
                        ])
                        ->columns(2)
                        ->placeholder('No files.'),
                ]),
            Section::make('Status History')
                ->schema([
                    RepeatableEntry::make('statusHistories')
                        ->schema([
                            TextEntry::make('status')->badge(),
                            TextEntry::make('note')->placeholder('-'),
                            TextEntry::make('user.name')->label('Changed by')->placeholder('-'),
                            TextEntry::make('created_at')->dateTime(),
                        ])
                        ->columns(4)
                        ->placeholder('No status history.'),
                ]),
            Section::make('Notes')
                ->schema([
                    TextEntry::make('notes')->placeholder('-')->columnSpanFull(),
                ]),
        ]);
    }
}
