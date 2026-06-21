<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans;

use App\Filament\Admin\Resources\ActivityPlans\Pages\CreateActivityPlan;
use App\Filament\Admin\Resources\ActivityPlans\Pages\EditActivityPlan;
use App\Filament\Admin\Resources\ActivityPlans\Pages\ListActivityPlans;
use App\Filament\Admin\Resources\ActivityPlans\Schemas\ActivityPlanForm;
use App\Filament\Admin\Resources\ActivityPlans\Tables\ActivityPlansTable;
use App\Models\ActivityPlan;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ActivityPlanResource extends Resource
{
    protected static ?string $model = ActivityPlan::class;

    protected static ?string $slug = 'employees/configurations/activity-plans';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    public static function getNavigationLabel(): string
    {
        return __('filament.employees.configurations.menu.activity_plans');
    }

    public static function getModelLabel(): string
    {
        return __('filament.employees.configurations.activity_plans.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.employees.configurations.activity_plans.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function configurationMenuKey(): string
    {
        return 'activity_plans';
    }

    public static function form(Schema $schema): Schema
    {
        return ActivityPlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ActivityPlansTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListActivityPlans::route('/'),
            'create' => CreateActivityPlan::route('/create'),
            'edit' => EditActivityPlan::route('/{record}/edit'),
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
