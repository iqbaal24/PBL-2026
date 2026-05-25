<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductFinishing;
use App\Models\ProductVariant;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingCart;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'order_code';

    public static function getGloballySearchableAttributes(): array
    {
        return ['order_code', 'customer_name', 'customer_phone'];
    }

    public static function form(Schema $schema): Schema
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
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state): void {
                                        $product = $state ? Product::find($state) : null;

                                        $set('product_name', $product?->name);
                                        $set('product_variant_id', null);
                                        $set('variant_name', null);
                                        $set('product_finishing_id', null);
                                        $set('finishing_name', null);
                                        $set('unit_price', $product?->base_price);
                                    }),
                                Select::make('product_variant_id')
                                    ->label('Variant')
                                    ->options(fn (Get $get): array => ProductVariant::query()
                                        ->where('product_id', $get('product_id'))
                                        ->orderBy('variant_name')
                                        ->pluck('variant_name', 'id')
                                        ->all())
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state): void {
                                        $variant = $state ? ProductVariant::find($state) : null;

                                        $set('variant_name', $variant?->variant_name);

                                        if ($variant?->price !== null) {
                                            $set('unit_price', $variant->price);
                                        }
                                    }),
                                Select::make('product_finishing_id')
                                    ->label('Finishing')
                                    ->options(fn (Get $get): array => ProductFinishing::query()
                                        ->where('product_id', $get('product_id'))
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->all())
                                    ->searchable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state): void {
                                        $set('finishing_name', $state ? ProductFinishing::find($state)?->name : null);
                                    }),
                                Hidden::make('product_name')->required(),
                                Hidden::make('variant_name'),
                                Hidden::make('finishing_name'),
                                TextInput::make('quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Get $get, Set $set) => $set('subtotal', ((float) $get('quantity')) * ((float) $get('unit_price')))),
                                TextInput::make('unit_price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Get $get, Set $set) => $set('subtotal', ((float) $get('quantity')) * ((float) $get('unit_price')))),
                                TextInput::make('subtotal')
                                    ->numeric()
                                    ->prefix('Rp'),
                                Textarea::make('specification')
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
                                ->options(self::fileTypeOptions())
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
                            ->options(self::paymentStatusOptions())
                            ->default('unpaid')
                            ->required(),
                    ]),
                ]),
            Section::make('Status')
                ->schema([
                    Select::make('status')
                        ->options(self::statusOptions())
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
                            Select::make('status')->options(self::statusOptions())->required(),
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

    public static function table(Table $table): Table
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
                SelectFilter::make('status')->options(self::statusOptions()),
                SelectFilter::make('payment_status')->options(self::paymentStatusOptions()),
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
                            ->options(self::statusOptions())
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
                            'changed_by' => \Illuminate\Support\Facades\Auth::id(),
                        ]);
                    }),
                \Filament\Actions\EditAction::make()->slideOver(),
                \Filament\Actions\DeleteAction::make()
                    ->modalDescription('Apakah Anda yakin ingin menghapus pesanan ini? Tindakan ini tidak dapat dibatalkan.'),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('updateBulkStatus')
                        ->label('Update Status Massal')
                        ->icon('heroicon-m-arrow-path')
                        ->color('warning')
                        ->form([
                            \Filament\Forms\Components\Select::make('status')
                                ->options(self::statusOptions())
                                ->required(),
                            \Filament\Forms\Components\Textarea::make('note')
                                ->label('Catatan (Opsional)')
                                ->rows(2),
                        ])
                        ->action(function (\Illuminate\Database\Eloquent\Collection $records, array $data): void {
                            $records->each(function (Order $record) use ($data) {
                                $record->update(['status' => $data['status']]);
                                $record->statusHistories()->create([
                                    'status' => $data['status'],
                                    'note' => $data['note'] ?? 'Bulk update',
                                    'changed_by' => \Illuminate\Support\Facades\Auth::id(),
                                ]);
                            });
                        })
                        ->deselectRecordsAfterCompletion(),
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOrders::route('/'),
            'create' => CreateOrder::route('/create'),
            'view' => ViewOrder::route('/{record}'),
            'edit' => EditOrder::route('/{record}/edit'),
        ];
    }

    public static function infolist(Schema $schema): Schema
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
                            TextEntry::make('variant_name')->label('Variant')->placeholder('-'),
                            TextEntry::make('finishing_name')->label('Finishing')->placeholder('-'),
                            TextEntry::make('quantity'),
                            TextEntry::make('unit_price')->money('IDR')->placeholder('-'),
                            TextEntry::make('subtotal')->money('IDR')->placeholder('-'),
                            TextEntry::make('specification')->placeholder('-')->columnSpanFull(),
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

    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'confirmed' => 'Confirmed',
            'production' => 'Production',
            'ready' => 'Ready',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    }

    public static function paymentStatusOptions(): array
    {
        return [
            'unpaid' => 'Unpaid',
            'partial' => 'Partial',
            'paid' => 'Paid',
        ];
    }

    public static function fileTypeOptions(): array
    {
        return [
            'design' => 'Design',
            'proof' => 'Proof',
            'receipt' => 'Receipt',
            'other' => 'Other',
        ];
    }
}
