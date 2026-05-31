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
        $statusWasChanged = $this->record->wasChanged('status');

        $this->updatePaymentTotal();

        $note = trim((string) data_get($this->data, 'status_history_note'));

        if (! $statusWasChanged && $note === '') {
            return;
        }

        $this->record->statusHistories()->create([
            'status' => $this->record->status,
            'note' => $note !== '' ? $note : 'Status diperbarui dari dashboard admin.',
            'changed_by' => Auth::id(),
        ]);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }

    private function updatePaymentTotal(): void
    {
        $itemSubtotal = (int) $this->record->items()->sum('subtotal');

        $this->record->forceFill([
            'total_price' => $itemSubtotal + (int) $this->record->shipping_fee + (int) $this->record->design_fee,
        ])->saveQuietly();
    }
}
