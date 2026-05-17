<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        $note = trim((string) data_get($this->data, 'status_history_note'));

        if (! $this->record->wasChanged('status') && $note === '') {
            return;
        }

        $this->record->statusHistories()->create([
            'status' => $this->record->status,
            'note' => $note !== '' ? $note : 'Status updated from admin dashboard.',
            'changed_by' => Auth::id(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
