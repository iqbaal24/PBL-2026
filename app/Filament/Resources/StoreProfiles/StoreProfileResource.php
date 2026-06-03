<?php

namespace App\Filament\Resources\StoreProfiles;

use App\Filament\Resources\StoreProfiles\Pages\CreateStoreProfile;
use App\Filament\Resources\StoreProfiles\Pages\EditStoreProfile;
use App\Filament\Resources\StoreProfiles\Pages\ListStoreProfiles;
use App\Filament\Resources\StoreProfiles\Pages\ViewStoreProfile;
use App\Filament\Resources\StoreProfiles\Schemas\StoreProfileForm;
use App\Filament\Resources\StoreProfiles\Tables\StoreProfileTable;
use App\Models\StoreProfile;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StoreProfileResource extends Resource
{
    protected static ?string $model = StoreProfile::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingStorefront;

    protected static ?string $navigationLabel = 'Store Profile';

    protected static ?int $navigationSort = 4;

    public static function form(Schema $schema): Schema
    {
        return StoreProfileForm::make($schema);
    }

    public static function table(Table $table): Table
    {
        return StoreProfileTable::make($table);
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
