<?php

namespace App\Filament\Resources\StoreProfiles\Pages;

use App\Filament\Resources\StoreProfiles\StoreProfileResource;
use App\Models\StoreProfile;
use Filament\Resources\Pages\ListRecords;

class ListStoreProfiles extends ListRecords
{
    protected static string $resource = StoreProfileResource::class;

    public function mount(): void
    {
        $record = StoreProfile::query()->first();

        $this->redirect(
            $record
                ? static::getResource()::getUrl('edit', ['record' => $record])
                : static::getResource()::getUrl('create'),
            navigate: true,
        );
    }
}
