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
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\Auth;

class OrderForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Wizard::make([
                Step::make('Customer')
                    ->description('Basic customer and deadline information.')
                    ->icon(Heroicon::User)
                    ->schema([
                        Section::make('Customer Info')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('order_code')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->helperText('Nomor pesanan dibuat otomatis saat order disimpan.')
                                        ->placeholder('Generated when saved'),
                                    TextInput::make('customer_name')
                                        ->helperText('Nama pelanggan atau nama usaha yang melakukan pesanan.')
                                        ->required()
                                        ->maxLength(255),
                                    TextInput::make('customer_phone')
                                        ->label('WhatsApp Number')
                                        ->helperText('Nomor WhatsApp pelanggan untuk konfirmasi dan tracking.')
                                        ->tel()
                                        ->required()
                                        ->maxLength(255),
                                    DatePicker::make('deadline')
                                        ->helperText('Tanggal pesanan dibutuhkan pelanggan, jika ada.'),
                                    Select::make('pickup_method')
                                        ->label('Pickup Method')
                                        ->helperText('Cara pelanggan mengambil pesanan setelah selesai.')
                                        ->options(OrderResource::pickupMethodOptions())
                                        ->searchable(),
                                    Select::make('design_file_status')
                                        ->label('Design File Status')
                                        ->helperText('Status kesiapan file desain dari pelanggan.')
                                        ->options(OrderResource::designFileStatusOptions())
                                        ->searchable(),
                                    Textarea::make('customer_address')
                                        ->helperText('Alamat pelanggan jika pesanan dikirim atau perlu dicatat.')
                                        ->rows(3)
                                        ->columnSpanFull(),
                                    Hidden::make('admin_id')
                                        ->default(fn () => Auth::id()),
                                ]),
                            ]),
                    ]),
                Step::make('Items')
                    ->description('Products, quantities, and production specs.')
                    ->icon(Heroicon::ShoppingBag)
                    ->schema([
                        Section::make('Order Items')
                            ->schema([
                                Repeater::make('items')
                                    ->helperText('Tambahkan satu baris untuk setiap produk yang dipesan.')
                                    ->relationship()
                                    ->schema([
                                        Grid::make(3)->schema([
                                            Select::make('product_id')
                                                ->label('Product')
                                                ->helperText('Pilih produk dari katalog sebagai acuan pesanan.')
                                                ->options(fn () => Product::query()->orderBy('name')->pluck('name', 'id'))
                                                ->searchable()
                                                ->nullable()
                                                ->live()
                                                ->afterStateUpdated(function (Get $get, Set $set, ?int $state): void {
                                                    $product = $state ? Product::find($state) : null;
                                                    $unitPrice = $product ? (int) $product->base_price : 0;

                                                    $set('product_name', $product?->name);
                                                    $set('variant_name', null);
                                                    $set('finishing_name', null);
                                                    $set('unit_price', $unitPrice);
                                                    $set('subtotal', ((int) $get('quantity')) * $unitPrice);
                                                    self::refreshOrderTotal($get, $set, '../../');
                                                }),
                                            Hidden::make('product_name'),
                                            Select::make('variant_name')
                                                ->label('Variant')
                                                ->helperText('Simpan varian sebagai snapshot agar histori order tidak berubah.')
                                                ->options(function (Get $get): array {
                                                    $productId = $get('product_id');

                                                    if (! $productId) {
                                                        return [];
                                                    }

                                                    return Product::query()
                                                        ->find($productId)
                                                        ?->activeVariants()
                                                        ->orderBy('variant_name')
                                                        ->pluck('variant_name', 'variant_name')
                                                        ->all() ?? [];
                                                })
                                                ->placeholder('Konsultasi produk')
                                                ->searchable(),
                                            Select::make('finishing_name')
                                                ->label('Finishing')
                                                ->helperText('Pilih finishing yang diminta pelanggan, jika ada.')
                                                ->options(function (Get $get): array {
                                                    $productId = $get('product_id');

                                                    if (! $productId) {
                                                        return [];
                                                    }

                                                    return Product::query()
                                                        ->find($productId)
                                                        ?->activeFinishings()
                                                        ->orderBy('name')
                                                        ->pluck('name', 'name')
                                                        ->all() ?? [];
                                                })
                                                ->placeholder('Belum ditentukan, konsultasi dulu')
                                                ->searchable(),
                                            TextInput::make('size')
                                                ->label('Size')
                                                ->helperText('Ukuran cetak untuk item ini, misalnya A3 atau 60 x 160 cm.')
                                                ->maxLength(255)
                                                ->placeholder('A3, 60 x 160 cm, 3 x 1 m'),
                                            TextInput::make('quantity')
                                                ->helperText('Jumlah item yang dipesan pelanggan.')
                                                ->numeric()
                                                ->integer()
                                                ->default(1)
                                                ->minValue(1)
                                                ->required()
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(function (Get $get, Set $set): void {
                                                    $set('subtotal', self::calculateItemSubtotal($get));
                                                    self::refreshOrderTotal($get, $set, '../../');
                                                }),
                                            TextInput::make('unit_price')
                                                ->label('Unit Price')
                                                ->helperText('Harga satuan item sebelum dikalikan jumlah.')
                                                ->numeric()
                                                ->integer()
                                                ->minValue(0)
                                                ->prefix('Rp')
                                                ->default(0)
                                                ->required()
                                                ->live(onBlur: true)
                                                ->afterStateUpdated(function (Get $get, Set $set): void {
                                                    $set('subtotal', self::calculateItemSubtotal($get));
                                                    self::refreshOrderTotal($get, $set, '../../');
                                                }),
                                            TextInput::make('subtotal')
                                                ->helperText('Subtotal item dari jumlah dikalikan harga satuan.')
                                                ->numeric()
                                                ->integer()
                                                ->minValue(0)
                                                ->prefix('Rp')
                                                ->default(0)
                                                ->readOnly()
                                                ->required(),
                                            Textarea::make('specification')
                                                ->label('Specification from WhatsApp')
                                                ->helperText('Isi kebutuhan teknis pelanggan dari chat WhatsApp untuk item ini.')
                                                ->required()
                                                ->rows(3)
                                                ->columnSpanFull(),
                                            Textarea::make('general_notes')
                                                ->label('Admin Item Notes')
                                                ->helperText('Catatan internal admin untuk item ini, tidak harus berasal dari pelanggan.')
                                                ->rows(3)
                                                ->columnSpanFull(),
                                        ]),
                                    ])
                                    ->columns(1)
                                    ->defaultItems(1)
                                    ->itemLabel(fn (array $state): ?string => $state['product_name'] ?? 'Order item')
                                    ->addActionLabel('Add item')
                                    ->live()
                                    ->afterStateUpdated(fn (Get $get, Set $set) => self::refreshOrderTotal($get, $set))
                                    ->required(),
                            ]),
                    ]),
                Step::make('Files')
                    ->description('Design, proof, receipt, and supporting files.')
                    ->icon(Heroicon::PaperClip)
                    ->schema([
                        Section::make('Files')
                            ->schema([
                                Repeater::make('files')
                                    ->helperText('Lampirkan file desain, proof, bukti pembayaran, atau file pendukung order.')
                                    ->relationship()
                                    ->schema([
                                        FileUpload::make('file_path')
                                            ->label('File')
                                            ->helperText('Upload file yang berkaitan dengan pesanan.')
                                            ->disk('public')
                                            ->directory('orders')
                                            ->storeFileNamesIn('file_name')
                                            ->required(),
                                        Hidden::make('file_name'),
                                        Select::make('file_type')
                                            ->helperText('Kategori file agar admin mudah membedakan jenis lampiran.')
                                            ->options(OrderResource::fileTypeOptions())
                                            ->required()
                                            ->default('design'),
                                        Select::make('order_item_id')
                                            ->label('Related item')
                                            ->helperText('Hubungkan file ke item tertentu jika file hanya berlaku untuk satu produk.')
                                            ->relationship('orderItem', 'product_name')
                                            ->searchable(),
                                        Hidden::make('uploaded_by')
                                            ->default(fn () => Auth::id()),
                                    ])
                                    ->columns(2)
                                    ->defaultItems(0)
                                    ->itemLabel(fn (array $state): ?string => $state['file_name'] ?? 'Order file')
                                    ->addActionLabel('Add file'),
                            ]),
                    ]),
                Step::make('Payment')
                    ->description('Order total and payment progress.')
                    ->icon(Heroicon::Wallet)
                    ->schema([
                        Section::make('Payment')
                            ->schema([
                                Grid::make(3)->schema([
                                    TextInput::make('shipping_fee')
                                        ->label('Shipping Fee')
                                        ->helperText('Ongkos kirim tambahan di luar subtotal item.')
                                        ->numeric()
                                        ->integer()
                                        ->minValue(0)
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Get $get, Set $set) => self::refreshOrderTotal($get, $set))
                                        ->required(),
                                    TextInput::make('design_fee')
                                        ->label('Design Fee')
                                        ->helperText('Biaya jasa desain tambahan jika pelanggan membutuhkan bantuan desain.')
                                        ->numeric()
                                        ->integer()
                                        ->minValue(0)
                                        ->prefix('Rp')
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Get $get, Set $set) => self::refreshOrderTotal($get, $set)),
                                    TextInput::make('total_price')
                                        ->helperText('Total otomatis: subtotal item + ongkos kirim + biaya desain.')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->readOnly()
                                        ->required(),
                                    TextInput::make('paid_amount')
                                        ->helperText('Nominal yang sudah dibayar pelanggan.')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->default(0)
                                        ->live(onBlur: true)
                                        ->afterStateUpdated(fn (Get $get, Set $set) => self::refreshPaymentStatus($get, $set))
                                        ->required(),
                                    Select::make('payment_status')
                                        ->helperText('Status otomatis berdasarkan nominal yang sudah diterima.')
                                        ->options(OrderResource::paymentStatusOptions())
                                        ->default('unpaid')
                                        ->disabled()
                                        ->dehydrated()
                                        ->required(),
                                ]),
                            ]),
                    ]),
                Step::make('Status')
                    ->description('Production status and internal history note.')
                    ->icon(Heroicon::Flag)
                    ->schema([
                        Section::make('Status')
                            ->schema([
                                Select::make('status')
                                    ->helperText('Tahap produksi pesanan yang akan terlihat di tracking pelanggan.')
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
                                    ->helperText('Riwayat perubahan status pesanan, dibuat otomatis saat status diperbarui.')
                                    ->relationship()
                                    ->schema([
                                        Select::make('status')
                                            ->helperText('Status yang tercatat pada riwayat.')
                                            ->options(OrderResource::statusOptions())
                                            ->required(),
                                        Textarea::make('note')
                                            ->helperText('Catatan perubahan status.')
                                            ->rows(2),
                                        Select::make('changed_by')
                                            ->helperText('Admin yang melakukan perubahan status.')
                                            ->relationship('user', 'name')
                                            ->disabled(),
                                    ])
                                    ->columns(3)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->defaultItems(0)
                                    ->hiddenOn('create'),
                            ]),
                    ]),
                Step::make('Notes')
                    ->description('Additional admin notes for this order.')
                    ->icon(Heroicon::ClipboardDocument)
                    ->schema([
                        Section::make('Notes')
                            ->schema([
                                Textarea::make('notes')
                                    ->helperText('Catatan umum untuk seluruh order, bukan catatan item spesifik.')
                                    ->rows(4)
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ])
                ->persistStepInQueryString()
                ->columnSpanFull(),
        ]);
    }

    private static function calculateItemSubtotal(Get $get): int
    {
        return ((int) $get('quantity')) * ((int) $get('unit_price'));
    }

    private static function refreshOrderTotal(Get $get, Set $set, string $rootPath = ''): void
    {
        $items = $get($rootPath . 'items');
        $itemSubtotal = collect(is_array($items) ? $items : [])
            ->sum(fn (mixed $item): int => (int) data_get($item, 'subtotal', 0));

        $shippingFee = (int) ($get($rootPath . 'shipping_fee') ?? 0);
        $designFee = (int) ($get($rootPath . 'design_fee') ?? 0);
        $totalPrice = $itemSubtotal + $shippingFee + $designFee;

        $set($rootPath . 'total_price', $totalPrice);
        self::refreshPaymentStatus($get, $set, $rootPath, $totalPrice);
    }

    private static function refreshPaymentStatus(Get $get, Set $set, string $rootPath = '', ?int $totalPrice = null): void
    {
        $totalPrice ??= (int) ($get($rootPath . 'total_price') ?? 0);
        $paidAmount = (int) ($get($rootPath . 'paid_amount') ?? 0);

        $status = match (true) {
            $paidAmount <= 0 => 'unpaid',
            $totalPrice > 0 && $paidAmount >= $totalPrice => 'paid',
            default => 'partial',
        };

        $set($rootPath . 'payment_status', $status);
    }
}
