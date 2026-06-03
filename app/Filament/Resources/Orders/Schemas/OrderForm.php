<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Auth;

class OrderForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Customer Info')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('order_code')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Generated when saved'),
                        TextInput::make('customer_name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('customer_phone')
                            ->label('WhatsApp Number')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('deadline'),
                        Textarea::make('customer_address')
                            ->rows(3)
                            ->columnSpanFull(),
                        Hidden::make('admin_id')
                            ->default(fn () => Auth::id()),
                    ]),
                ]),
            Section::make('Order Items')
                ->schema([
                    Repeater::make('items')
                        ->relationship()
                        ->schema([
                            Grid::make(3)->schema([
                                Select::make('product_id')
                                    ->label('Product')
                                    ->options(fn () => Product::query()->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state): void {
                                        $product = $state ? Product::find($state) : null;

                                        $set('product_name', $product?->name);
                                        $set('unit_price', $product ? (int) $product->base_price : 0);
                                    }),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->integer()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Get $get, Set $set) => $set('subtotal', ((int) $get('quantity')) * ((int) $get('unit_price')))),
                                TextInput::make('unit_price')
                                    ->label('Unit Price')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->default(0)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Get $get, Set $set) => $set('subtotal', ((int) $get('quantity')) * ((int) $get('unit_price')))),
                                TextInput::make('subtotal')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->default(0)
                                    ->required(),
                                Textarea::make('specification')
                                    ->label('Specification from WhatsApp')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                Textarea::make('general_notes')
                                    ->label('Admin Item Notes')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                        ])
                        ->columns(1)
                        ->defaultItems(1)
                        ->addActionLabel('Add item')
                        ->required(),
                ]),
            Section::make('Files')
                ->schema([
                    Repeater::make('files')
                        ->relationship()
                        ->schema([
                            FileUpload::make('file_path')
                               ->label('File')
                                ->disk('public')
                                ->directory('orders')
                                ->storeFileNamesIn('file_name')
                                ->required(),
                            Hidden::make('file_name'),
                            Select::make('file_type')
                                ->options(OrderResource::fileTypeOptions())
                                ->required()
                                ->default('design'),
                            Select::make('order_item_id')
                                ->label('Related item')
                                ->relationship('orderItem', 'product_name')
                                ->searchable(),
                            Hidden::make('uploaded_by')
                                ->default(fn () => Auth::id()),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('Add file'),
                ]),
            Section::make('Payment')
                ->schema([
                    Grid::make(3)->schema([
                        TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->required(),
                        TextInput::make('paid_amount')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required(),
                        Select::make('payment_status')
                            ->options(OrderResource::paymentStatusOptions())
                            ->default('unpaid')
                            ->required(),
                    ]),
                ]),
            Section::make('Status')
                ->schema([
                    Select::make('status')
                        ->options(OrderResource::statusOptions())
                        ->default('pending')
                        ->required(),
                    Textarea::make('status_history_note')
                        ->label('Status History Note')
                        ->helperText('This note will be saved to the status history when the order is created or when you update the status.')
                        ->rows(3)
                        ->dehydrated(false)
                        ->columnSpanFull(),
                    Repeater::make('statusHistories')
                        ->relationship()
                        ->schema([
                            Select::make('status')->options(OrderResource::statusOptions())->required(),
                            Textarea::make('note')->rows(2),
                            Select::make('changed_by')->relationship('user', 'name')->disabled(),
                        ])
                        ->columns(3)
                        ->disabled()
                        ->dehydrated(false)
                        ->defaultItems(0)
                        ->hiddenOn('create'),
                ]),
            Section::make('Notes')
                ->schema([
                    Textarea::make('notes')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
        ]);
    }
}
