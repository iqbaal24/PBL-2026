<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static ?string $navigationLabel = 'Admin Users';

    protected static ?int $navigationSort = 5;

    public static function canAccess(): bool
    {
        return Auth::user()?->role === 'superadmin';
    }

    public static function canCreate(): bool
    {
        return static::canAccess();
    }

    public static function canEdit(Model $record): bool
    {
        return static::canAccess();
    }

    public static function canDelete(Model $record): bool
    {
        if (! static::canAccess()) {
            return false;
        }

        if (Auth::id() === $record->getKey()) {
            return false;
        }

        if ($record->role === 'superadmin' && User::query()->where('role', 'superadmin')->count() <= 1) {
            return false;
        }

        return true;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Admin Account')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make('name')->required()->maxLength(255),
                        TextInput::make('email')->email()->required()->maxLength(255)->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state)),
                        Select::make('role')
                            ->options([
                                'admin' => 'Admin',
                                'superadmin' => 'Superadmin',
                            ])
                            ->default('admin')
                            ->required(),
                        Toggle::make('is_active')
                            ->default(true),
                    ]),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('role')->badge()->sortable(),
                IconColumn::make('is_active')->boolean()->sortable(),
                TextColumn::make('orders_count')->counts('orders')->label('Orders')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('role')->options([
                    'admin' => 'Admin',
                    'superadmin' => 'Superadmin',
                ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->visible(fn (User $record): bool => static::canDelete($record)),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
