<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates;

use App\Filament\Admin\Resources\Recruitments\Candidates\Pages\CreateRecruitmentCandidate;
use App\Filament\Admin\Resources\Recruitments\Candidates\Pages\EditRecruitmentCandidate;
use App\Filament\Admin\Resources\Recruitments\Candidates\Pages\ListRecruitmentCandidates;
use App\Filament\Admin\Resources\Recruitments\Candidates\Schemas\RecruitmentCandidateForm;
use App\Filament\Admin\Resources\Recruitments\Candidates\Tables\RecruitmentCandidatesTable;
use App\Models\RecruitmentCandidate;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RecruitmentCandidateResource extends Resource
{
    protected static ?string $model = RecruitmentCandidate::class;

    protected static ?string $slug = 'recruitments/applications/candidates';

    protected static ?string $navigationLabel = null;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUser;

    public static function applicationsMenuKey(): string
    {
        return 'candidates';
    }

    public static function getNavigationLabel(): string
    {
        return __('filament.recruitments.applications.menu.candidates');
    }

    public static function getModelLabel(): string
    {
        return __('filament.recruitments.candidates.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.recruitments.candidates.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return RecruitmentCandidateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return RecruitmentCandidatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRecruitmentCandidates::route('/'),
            'create' => CreateRecruitmentCandidate::route('/create'),
            'edit' => EditRecruitmentCandidate::route('/{record}/edit'),
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
