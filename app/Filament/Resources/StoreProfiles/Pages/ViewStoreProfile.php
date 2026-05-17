<?php

namespace App\Filament\Resources\StoreProfiles\Pages;

use App\Filament\Resources\StoreProfiles\StoreProfileResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStoreProfile extends ViewRecord
{
    protected static string $resource = StoreProfileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
