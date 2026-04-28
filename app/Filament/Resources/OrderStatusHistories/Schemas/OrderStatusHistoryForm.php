<?php

namespace App\Filament\Resources\OrderStatusHistories\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderStatusHistoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                TextInput::make('status')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
                TextInput::make('updated_by')
                    ->numeric(),
            ]);
    }
}
