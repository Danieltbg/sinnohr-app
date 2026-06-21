<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Users;

use App\Filament\Admin\Resources\Settings\Users\Pages\CreateSettingsUser;
use App\Filament\Admin\Resources\Settings\Users\Pages\EditSettingsUser;
use App\Filament\Admin\Resources\Settings\Users\Pages\ListSettingsUsers;
use App\Filament\Admin\Resources\Users\Schemas\UserForm;
use App\Filament\Admin\Resources\Settings\Users\Tables\SettingsUsersTable;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'settings/users';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.users.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.users.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.users.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsUsersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettingsUsers::route('/'),
            'create' => CreateSettingsUser::route('/create'),
            'edit' => EditSettingsUser::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
