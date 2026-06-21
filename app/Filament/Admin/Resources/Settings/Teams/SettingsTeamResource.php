<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams;

use App\Filament\Admin\Resources\Settings\Teams\Pages\CreateSettingsTeam;
use App\Filament\Admin\Resources\Settings\Teams\Pages\EditSettingsTeam;
use App\Filament\Admin\Resources\Settings\Teams\Pages\ListSettingsTeams;
use App\Filament\Admin\Resources\Settings\Teams\Schemas\SettingsTeamForm;
use App\Filament\Admin\Resources\Settings\Teams\Tables\SettingsTeamsTable;
use App\Models\MasterTeam;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsTeamResource extends Resource
{
    protected static ?string $model = MasterTeam::class;

    protected static ?string $slug = 'settings/teams';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.teams.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.teams.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.teams.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return SettingsTeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsTeamsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettingsTeams::route('/'),
            'create' => CreateSettingsTeam::route('/create'),
            'edit' => EditSettingsTeam::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
