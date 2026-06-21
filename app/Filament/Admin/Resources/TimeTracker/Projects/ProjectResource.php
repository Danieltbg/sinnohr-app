<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Resources\TimeTracker\Projects\Pages\CreateProject;
use App\Filament\Admin\Resources\TimeTracker\Projects\Pages\EditProject;
use App\Filament\Admin\Resources\TimeTracker\Projects\Pages\ListProjects;
use App\Filament\Admin\Resources\TimeTracker\Projects\Schemas\ProjectForm;
use App\Filament\Admin\Resources\TimeTracker\Projects\Tables\ProjectsTable;
use App\Models\Project;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $slug = 'time-tracker/projects';

    protected static string|\BackedEnum|null $navigationIcon = Heroicon::OutlinedFolder;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TIME_TRACKER;

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return ProjectForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProjectsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProjects::route('/'),
            'create' => CreateProject::route('/create'),
            'edit' => EditProject::route('/{record}/edit'),
        ];
    }
}
