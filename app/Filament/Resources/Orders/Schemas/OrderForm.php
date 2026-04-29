<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                TextInput::make('order_number')
                    ->required(),
                TextInput::make('total_amount')
                    ->required()
                    ->numeric(),
                TextInput::make('current_status')
                    ->required()
                    ->default('pending'),
                TextInput::make('delivery_type')
                    ->required()
                    ->default('shipping'),
                TextInput::make('recipient_name')
                    ->required(),
                TextInput::make('recipient_phone')
                    ->tel()
                    ->required(),
                Textarea::make('shipping_address')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('shipping_city_id')
                    ->required()
                    ->numeric(),
                TextInput::make('total_weight')
                    ->required()
                    ->numeric(),
                TextInput::make('courier'),
                TextInput::make('courier_service'),
                TextInput::make('shipping_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->prefix('$'),
                TextInput::make('tracking_number'),
            ]);
    }
}
