<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use App\Models\Post;
use Filament\Actions\Action;

use Filament\Support\Enums\IconSize;
use Filament\Support\Facades\FilamentIcon;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'User';


    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema)
        ->schema([
            TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(20)
                ->minLength(3),
            TextInput::make('email')
                ->label('E-Mail')
                ->required()
                ->email(),
            TextInput::make('password')
                ->label('Password')
                ->required()
                ->password(),
        ]);
        
    }

    public static function table(Table $table): Table
    {
    return UsersTable::configure($table)
        ->columns([
            TextColumn::make('name')->label('Full Name'),
            TextColumn::make('email')->label('E-Mail'),
        ])
        ->filters([
            
        ]);
    }

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('admin');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }
}
