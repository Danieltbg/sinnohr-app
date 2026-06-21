<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Applicants;

use App\Filament\Admin\Resources\Recruitments\Applicants\Pages\CreateRecruitmentApplicant;
use App\Filament\Admin\Resources\Recruitments\Applicants\Pages\EditRecruitmentApplicant;
use App\Filament\Admin\Resources\Recruitments\Applicants\Pages\ListRecruitmentApplicants;
use App\Filament\Admin\Resources\Recruitments\Applicants\Schemas\RecruitmentApplicantForm;
use App\Filament\Admin\Resources\Recruitments\Applicants\Tables\RecruitmentApplicantsTable;
use App\Models\RecruitmentApplicant;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecruitmentApplicantResource extends Resource
{
    protected static ?string $model = RecruitmentApplicant::class;

    protected static ?string $slug = 'recruitments/applications/applicants';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    public static function applicationsMenuKey(): string
    {
        return 'applicants';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.recruitments.applications.menu.applicants');
    }

    public static function getModelLabel(): string
    {
        return __('filament.recruitments.applicants.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.recruitments.applicants.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return RecruitmentApplicantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecruitmentApplicantsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecruitmentApplicants::route('/'),
            'create' => CreateRecruitmentApplicant::route('/create'),
            'edit' => EditRecruitmentApplicant::route('/{record}/edit'),
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
