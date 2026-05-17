<?php

namespace App\Filament\Resources\StoreProfiles;

use App\Filament\Resources\StoreProfiles\Pages\CreateStoreProfile;
use App\Filament\Resources\StoreProfiles\Pages\EditStoreProfile;
use App\Filament\Resources\StoreProfiles\Pages\ListStoreProfiles;
use App\Filament\Resources\StoreProfiles\Pages\ViewStoreProfile;
use App\Models\StoreProfile;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StoreProfileResource extends Resource
{
    protected static ?string $model = StoreProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Store Profile';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Business Profile')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('whatsapp_number')->required()->tel()->maxLength(255),
                        TextInput::make('email')->email()->maxLength(255),
                        TextInput::make('instagram_url')->url()->maxLength(255),
                        FileUpload::make('logo')
                            ->image()
                            ->disk('public')
                            ->directory('store')
                            ->visibility('public')
                            ->columnSpanFull(),
                        Textarea::make('about')->rows(4)->columnSpanFull(),
                        Textarea::make('address')->rows(3)->columnSpanFull(),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')->disk('public')->square(),
                TextColumn::make('name')->searchable(),
                TextColumn::make('whatsapp_number')->searchable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStoreProfiles::route('/'),
            'create' => CreateStoreProfile::route('/create'),
            'view' => ViewStoreProfile::route('/{record}'),
            'edit' => EditStoreProfile::route('/{record}/edit'),
        ];
    }
}
