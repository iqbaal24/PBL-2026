<?php

namespace App\Filament\Resources\Reviews\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ReviewForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Review')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('customer_name')->required()->maxLength(255),
                        TextInput::make('rating')->numeric()->minValue(1)->maxValue(5)->required(),
                        Select::make('product_id')->relationship('product', 'name')->searchable()->preload(),
                        Select::make('order_id')->relationship('order', 'order_code')->searchable()->preload(),
                        Textarea::make('comment')->required()->rows(4)->columnSpanFull(),
                        Toggle::make('is_visible')->default(true),
                    ]),
                ]),
        ]);
    }
}
