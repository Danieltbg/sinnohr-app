<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Roles;

use App\Filament\Admin\Resources\Settings\Roles\Pages\CreateRole;
use App\Filament\Admin\Resources\Settings\Roles\Pages\EditRole;
use App\Filament\Admin\Resources\Settings\Roles\Pages\ListRoles;
use App\Filament\Admin\Resources\Settings\Roles\Schemas\RoleForm;
use App\Filament\Admin\Resources\Settings\Roles\Tables\RolesTable;
use App\Models\Role;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $slug = 'settings/roles';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.roles.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.roles.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.roles.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return RoleForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RolesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
