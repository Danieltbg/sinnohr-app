<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Resources\TimeTracker\Teams\Pages\CreateTeam;
use App\Filament\Admin\Resources\TimeTracker\Teams\Pages\EditTeam;
use App\Filament\Admin\Resources\TimeTracker\Teams\Pages\ListTeams;
use App\Filament\Admin\Resources\TimeTracker\Teams\Schemas\TeamForm;
use App\Filament\Admin\Resources\TimeTracker\Teams\Tables\TeamsTable;
use App\Models\Team;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static ?string $slug = 'time-tracker/teams';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TIME_TRACKER;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return TeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
