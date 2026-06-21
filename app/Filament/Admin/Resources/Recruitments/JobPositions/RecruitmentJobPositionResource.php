<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions;

use App\Filament\Admin\Resources\Recruitments\JobPositions\Pages\CreateRecruitmentJobPosition;
use App\Filament\Admin\Resources\Recruitments\JobPositions\Pages\EditRecruitmentJobPosition;
use App\Filament\Admin\Resources\Recruitments\JobPositions\Pages\ListRecruitmentJobPositions;
use App\Filament\Admin\Resources\Recruitments\JobPositions\Schemas\RecruitmentJobPositionForm;
use App\Filament\Admin\Resources\Recruitments\JobPositions\Tables\RecruitmentJobPositionsTable;
use App\Models\RecruitmentJobPosition;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecruitmentJobPositionResource extends Resource
{
    protected static ?string $model = RecruitmentJobPosition::class;

    protected static ?string $slug = 'recruitments/applications/job-positions';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function applicationsMenuKey(): string
    {
        return 'job_positions';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.recruitments.applications.menu.job_positions');
    }

    public static function getModelLabel(): string
    {
        return __('filament.recruitments.job_positions.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.recruitments.job_positions.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return RecruitmentJobPositionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecruitmentJobPositionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecruitmentJobPositions::route('/'),
            'create' => CreateRecruitmentJobPosition::route('/create'),
            'edit' => EditRecruitmentJobPosition::route('/{record}/edit'),
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
