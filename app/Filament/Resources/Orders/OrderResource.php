<?php

namespace App\Filament\Resources\Orders;

use App\Filament\Resources\Orders\Pages\CreateOrder;
use App\Filament\Resources\Orders\Pages\EditOrder;
use App\Filament\Resources\Orders\Pages\ListOrders;
use App\Filament\Resources\Orders\Pages\ViewOrder;
use App\Models\Order;
use App\Models\Product;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Validation\Rule;

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
            Section::make('Informasi Pelanggan')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('order_code')
                            ->label('Kode Pesanan')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Dibuat otomatis saat disimpan'),
                        TextInput::make('customer_name')
                            ->label('Nama Pelanggan')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('customer_phone')
                            ->label('Nomor WhatsApp')
                            ->tel()
                            ->required()
                            ->maxLength(255),
                        DatePicker::make('deadline')
                            ->label('Tenggat'),
                        Textarea::make('customer_address')
                            ->label('Alamat Pelanggan')
                            ->rows(3)
                            ->columnSpanFull(),
                        Hidden::make('admin_id')
                            ->default(fn () => Auth::id()),
                    ]),
                ]),
            Section::make('Item Pesanan')
                ->schema([
                    Repeater::make('items')
                        ->label('Item')
                        ->relationship()
                        ->live()
                        ->afterStateUpdated(fn (Get $get, Set $set) => self::updateOrderTotal($get, $set))
                        ->schema([
                            Grid::make(3)->schema([
                                Select::make('product_id')
                                    ->label('Produk')
                                    ->options(fn () => Product::query()->orderBy('name')->pluck('name', 'id'))
                                    ->searchable()
                                    ->nullable()
                                    ->live()
                                    ->afterStateUpdated(function (Set $set, ?int $state): void {
                                        $product = $state ? Product::find($state) : null;

                                        $set('product_name', $product?->name);
                                    }),
                                // TextInput::make('product_name')
                                //     ->label('Nama Produk')
                                //     ->required()
                                //     ->maxLength(255),
                                Hidden::make('product_name')->required(),
                                Textarea::make('specification')
                                    ->label('Spesifikasi dari WhatsApp')
                                    ->required()
                                    ->rows(3)
                                    ->columnSpanFull(),
                                TextInput::make('quantity')
                                    ->label('Jumlah')
                                    ->numeric()
                                    ->integer()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set): void {
                                        self::updateItemSubtotal($set, $get('quantity'), $get('unit_price'));
                                        self::updateOrderTotalFromItem($get, $set);
                                    }),
                                TextInput::make('unit_price')
                                    ->label('Harga Satuan')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set): void {
                                        self::updateItemSubtotal($set, $get('quantity'), $get('unit_price'));
                                        self::updateOrderTotalFromItem($get, $set);
                                    }),
                                TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->integer()
                                    ->minValue(0)
                                    ->prefix('Rp')
                                    ->default(0)
                                    ->required()
                                    ->readOnly(),
                                Textarea::make('general_notes')
                                    ->label('Catatan Item dari Admin')
                                    ->rows(3)
                                    ->columnSpanFull(),
                            ]),
                        ])
                        ->columns(1)
                        ->defaultItems(1)
                        ->addActionLabel('Tambah item')
                        ->required(),
                ]),
            Section::make('File')
                ->schema([
                    Repeater::make('files')
                        ->label('File')
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
                                ->label('Jenis File')
                                ->options(self::fileTypeOptions())
                                ->required()
                                ->default('design'),
                            Select::make('order_item_id')
                                ->label('Item Terkait')
                                ->options(fn ($livewire): array => self::orderItemOptions($livewire))
                                ->searchable()
                                ->preload()
                                ->helperText(fn ($livewire): string => self::getLivewireOrder($livewire)
                                    ? 'Pilih item pesanan yang memakai file ini.'
                                    : 'Simpan pesanan dulu jika file perlu dihubungkan ke item tertentu.')
                                ->disabled(fn ($livewire): bool => ! self::getLivewireOrder($livewire))
                                ->rules(fn ($livewire): array => [
                                    'nullable',
                                    Rule::exists('order_items', 'id')->where('order_id', self::getLivewireOrder($livewire)?->id ?? 0),
                                ]),
                            Hidden::make('uploaded_by')
                                ->default(fn () => Auth::id()),
                        ])
                        ->columns(2)
                        ->defaultItems(0)
                        ->addActionLabel('Tambah file'),
                ]),
            Section::make('Pembayaran')
                ->schema([
                    Grid::make(3)->schema([
                        Placeholder::make('item_subtotal_display')
                            ->label('Subtotal Item')
                            ->content(fn (Get $get): string => self::formatRupiah(self::calculateItemSubtotal($get('items')))),
                        TextInput::make('shipping_fee')
                            ->label('Ongkos Kirim')
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->default(0)
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateOrderTotal($get, $set)),
                        TextInput::make('design_fee')
                            ->label('Biaya Desain')
                            ->numeric()
                            ->integer()
                            ->minValue(0)
                            ->prefix('Rp')
                            ->live()
                            ->afterStateUpdated(fn (Get $get, Set $set) => self::updateOrderTotal($get, $set)),
                        TextInput::make('total_price')
                            ->label('Total Keseluruhan')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required()
                            ->readOnly(),
                        TextInput::make('paid_amount')
                            ->label('Jumlah Dibayar (DP)')
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->required(),
                        Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options(self::paymentStatusOptions())
                            ->default('unpaid')
                            ->required(),
                    ]),
                ]),
            Section::make('Status')
                ->schema([
                    Select::make('status')
                        ->label('Status Pesanan')
                        ->options(self::statusOptions())
                        ->default('pending')
                        ->required(),
                    Textarea::make('status_history_note')
                        ->label('Catatan Riwayat Status')
                        ->helperText('Catatan ini akan disimpan ke riwayat status saat pesanan dibuat atau status diperbarui.')
                        ->rows(3)
                        ->dehydrated(false)
                        ->columnSpanFull(),
                    Repeater::make('statusHistories')
                        ->label('Riwayat Status')
                        ->relationship()
                        ->schema([
                            Select::make('status')->label('Status')->options(self::statusOptions())->required(),
                            Textarea::make('note')->label('Catatan')->rows(2),
                            Select::make('changed_by')->label('Diubah Oleh')->relationship('user', 'name')->disabled(),
                        ])
                        ->columns(3)
                        ->disabled()
                        ->dehydrated(false)
                        ->defaultItems(0)
                        ->hiddenOn('create'),
                ]),
            Section::make('Catatan')
                ->schema([
                    Textarea::make('notes')
                        ->label('Catatan Pesanan')
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
                    ->url(fn (Order $record): string => "https://wa.me/" . preg_replace('/[^0-9]/', '', $record->customer_phone) . "?text=" . urlencode("Halo {$record->customer_name}, kami dari Harapan Jaya Printing ingin menginformasikan bahwa pesanan Anda dengan nomor #{$record->order_code} sedang kami proses. Untuk mengecek progress pesanan secara mandiri, silakan buka halaman Lacak Pesanan di website kami dan masukkan nomor pesanan tersebut. Jika ada pertanyaan atau detail tambahan, silakan balas pesan ini."))
                    ->openUrlInNewTab(),
                \Filament\Actions\Action::make('updateStatus')
                    ->label('Update Progress')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->form([
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Status')
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
                ViewAction::make()
                    ->label('Lihat')
                    ->icon('heroicon-m-eye')
                    ->color('gray'),
                \Filament\Actions\EditAction::make()
                    ->label('Edit')
                    ->slideOver(),
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
                                ->label('Status')
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
            Section::make('Informasi Pelanggan')
                ->schema([
                    TextEntry::make('order_code')->label('Kode Pesanan')->copyable(),
                    TextEntry::make('customer_name')->label('Nama Pelanggan'),
                    TextEntry::make('customer_phone')->label('Nomor WhatsApp')->copyable(),
                    TextEntry::make('deadline')->label('Tenggat')->date()->placeholder('-'),
                    TextEntry::make('customer_address')->label('Alamat Pelanggan')->placeholder('-')->columnSpanFull(),
                    TextEntry::make('admin.name')->label('Admin')->placeholder('-'),
                    TextEntry::make('created_at')->label('Dibuat')->dateTime(),
                ])
                ->columns(2),
            Section::make('Item Pesanan')
                ->schema([
                    RepeatableEntry::make('items')
                        ->label('Item')
                        ->schema([
                            TextEntry::make('product_name')->label('Produk'),
                            TextEntry::make('specification')->label('Spesifikasi')->placeholder('-')->columnSpanFull(),
                            TextEntry::make('quantity')->label('Jumlah'),
                            TextEntry::make('unit_price')->label('Harga Satuan')->money('IDR')->placeholder('-'),
                            TextEntry::make('subtotal')->label('Subtotal')->money('IDR')->placeholder('-'),
                            TextEntry::make('general_notes')->label('Catatan Item dari Admin')->placeholder('-')->columnSpanFull(),
                        ])
                        ->columns(3)
                        ->placeholder('Tidak ada item.'),
                ]),
            Section::make('Pembayaran')
                ->schema([
                    TextEntry::make('items_sum_subtotal')->label('Subtotal Item')->state(fn (Order $record): int => (int) $record->items()->sum('subtotal'))->money('IDR'),
                    TextEntry::make('shipping_fee')->label('Ongkos Kirim')->money('IDR'),
                    TextEntry::make('design_fee')->label('Biaya Desain')->money('IDR')->placeholder('-'),
                    TextEntry::make('total_price')->label('Total Keseluruhan')->money('IDR')->placeholder('-'),
                    TextEntry::make('paid_amount')->label('Jumlah Dibayar (DP)')->money('IDR'),
                    TextEntry::make('payment_status')->label('Status Pembayaran')->badge(),
                    TextEntry::make('status')->label('Status Pesanan')->badge(),
                ])
                ->columns(3),
            Section::make('File')
                ->schema([
                    RepeatableEntry::make('files')
                        ->label('File')
                        ->schema([
                            TextEntry::make('file_name')->label('Nama File')->placeholder('-'),
                            TextEntry::make('file_type')->label('Jenis File')->badge(),
                            TextEntry::make('orderItem.product_name')->label('Item Terkait')->placeholder('-'),
                            TextEntry::make('uploader.name')->label('Diunggah Oleh')->placeholder('-'),
                            TextEntry::make('file_path')
                                ->label('Buka File')
                                ->url(fn (?string $state): ?string => $state ? Storage::disk('public')->url($state) : null)
                                ->openUrlInNewTab()
                                ->placeholder('-'),
                        ])
                        ->columns(2)
                        ->placeholder('Tidak ada file.'),
                ]),
            Section::make('Riwayat Status')
                ->schema([
                    RepeatableEntry::make('statusHistories')
                        ->label('Riwayat Status')
                        ->schema([
                            TextEntry::make('status')->label('Status')->badge(),
                            TextEntry::make('note')->label('Catatan')->placeholder('-'),
                            TextEntry::make('user.name')->label('Diubah Oleh')->placeholder('-'),
                            TextEntry::make('created_at')->label('Dibuat')->dateTime(),
                        ])
                        ->columns(4)
                        ->placeholder('Belum ada riwayat status.'),
                ]),
            Section::make('Catatan')
                ->schema([
                    TextEntry::make('notes')->label('Catatan Pesanan')->placeholder('-')->columnSpanFull(),
                ]),
        ]);
    }

    public static function statusOptions(): array
    {
        return [
            'pending' => 'Menunggu',
            'confirmed' => 'Dikonfirmasi',
            'production' => 'Produksi',
            'ready' => 'Siap Diambil',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
        ];
    }

    public static function paymentStatusOptions(): array
    {
        return [
            'unpaid' => 'Belum Dibayar',
            'partial' => 'Dibayar Sebagian',
            'paid' => 'Lunas',
        ];
    }

    public static function fileTypeOptions(): array
    {
        return [
            'design' => 'Desain',
            'proof' => 'Bukti Pembayaran',
            'receipt' => 'Nota',
            'other' => 'Lainnya',
        ];
    }

    private static function orderItemOptions(mixed $livewire): array
    {
        $order = self::getLivewireOrder($livewire);

        if (! $order) {
            return [];
        }

        return $order->items()
            ->orderBy('id')
            ->get()
            ->mapWithKeys(fn ($item): array => [
                $item->id => "{$item->quantity}x {$item->product_name}",
            ])
            ->all();
    }

    private static function getLivewireOrder(mixed $livewire): ?Order
    {
        if (! is_object($livewire) || ! method_exists($livewire, 'getRecord')) {
            return null;
        }

        $record = $livewire->getRecord();

        return $record instanceof Order ? $record : null;
    }

    private static function updateItemSubtotal(Set $set, mixed $quantity, mixed $unitPrice): void
    {
        $set('subtotal', max(0, (int) $quantity) * max(0, (int) $unitPrice));
    }

    public static function calculatePaymentTotal(array $items, mixed $shippingFee = 0, mixed $designFee = 0): int
    {
        return self::calculateItemSubtotal($items) + max(0, (int) $shippingFee) + max(0, (int) $designFee);
    }

    private static function updateOrderTotal(Get $get, Set $set): void
    {
        $set('total_price', self::calculatePaymentTotal(
            $get('items'),
            $get('shipping_fee'),
            $get('design_fee'),
        ));
    }

    private static function updateOrderTotalFromItem(Get $get, Set $set): void
    {
        $set('../../total_price', self::calculatePaymentTotal(
            $get('../../items'),
            $get('../../shipping_fee'),
            $get('../../design_fee'),
        ));
    }

    private static function calculateItemSubtotal(mixed $items): int
    {
        return collect(is_array($items) ? $items : [])
            ->sum(fn (array $item): int => max(0, (int) ($item['subtotal'] ?? 0)));
    }

    private static function formatRupiah(int $amount): string
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }
}
