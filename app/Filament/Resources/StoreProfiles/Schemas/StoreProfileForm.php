<?php

namespace App\Filament\Resources\StoreProfiles\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StoreProfileForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Business Profile')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('whatsapp_number')->required()->tel()->maxLength(255),
                        TextInput::make('email')->email()->maxLength(255),
                        TextInput::make('instagram_url')->url()->maxLength(255),
                        FileUpload::make('logo')
                            ->image()
                            ->disk('public')
                            ->directory('store')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->columnSpanFull(),
                        Textarea::make('about')->rows(4)->columnSpanFull(),
                        Textarea::make('address')->rows(3)->columnSpanFull(),
                        TextInput::make('maps_url')
                            ->label('Google Maps URL')
                            ->helperText('Tempel link lengkap lokasi dari Google Maps.')
                            ->url()
                            ->columnSpanFull(),
                        TextInput::make('maps_embed_url')
                            ->label('Google Maps Embed URL')
                            ->helperText('Tempel link embed (src dari iframe) dari Google Maps.')
                            ->url()
                            ->columnSpanFull(),
                    ]),
                ]),
        ]);
    }
}
