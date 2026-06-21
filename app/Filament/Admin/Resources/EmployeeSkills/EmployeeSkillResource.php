<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\EmployeeSkills;

use App\Filament\Admin\Resources\EmployeeSkills\Pages\ListEmployeeSkills;
use App\Filament\Admin\Resources\EmployeeSkills\Tables\EmployeeSkillsTable;
use App\Models\EmployeeSkill;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeSkillResource extends Resource
{
    protected static ?string $model = EmployeeSkill::class;

    protected static ?string $slug = 'employees/reportings/skills';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAcademicCap;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('filament.employees.reportings.skills.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.employees.reportings.skills.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.employees.reportings.skills.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return EmployeeSkillsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmployeeSkills::route('/'),
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
