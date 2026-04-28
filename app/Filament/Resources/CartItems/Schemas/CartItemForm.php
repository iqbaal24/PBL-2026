<?php

namespace App\Filament\Resources\CartItems\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CartItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('cart_id')
                    ->relationship('cart', 'id')
                    ->required(),
                Select::make('product_variant_id')
                    ->relationship('productVariant', 'id')
                    ->required(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
                TextInput::make('design_file_path'),
                Textarea::make('design_brief')
                    ->columnSpanFull(),
            ]);
    }
}
