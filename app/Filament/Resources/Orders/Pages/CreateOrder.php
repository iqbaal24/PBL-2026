<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['order_code'] ??= $this->makeOrderCode();
        $data['admin_id'] ??= Auth::id();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $record = parent::handleRecordCreation($data);
        $note = trim((string) data_get($this->data, 'status_history_note'));

        $record->statusHistories()->create([
            'status' => $record->status,
            'note' => $note !== '' ? $note : 'Order created.',
            'changed_by' => Auth::id(),
        ]);

        return $record;
    }

    private function makeOrderCode(): string
    {
        $date = now()->format('Ymd');
        $sequence = Order::query()
            ->whereDate('created_at', now()->toDateString())
            ->count() + 1;

        return sprintf('ORD-%s-%04d', $date, $sequence);
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
