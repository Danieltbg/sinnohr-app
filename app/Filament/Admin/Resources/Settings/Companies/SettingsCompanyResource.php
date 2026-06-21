<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies;

use App\Filament\Admin\Resources\Settings\Companies\Pages\CreateSettingsCompany;
use App\Filament\Admin\Resources\Settings\Companies\Pages\EditSettingsCompany;
use App\Filament\Admin\Resources\Settings\Companies\Pages\ListSettingsCompanies;
use App\Filament\Admin\Resources\Settings\Companies\Schemas\SettingsCompanyForm;
use App\Filament\Admin\Resources\Settings\Companies\Tables\SettingsCompaniesTable;
use App\Models\SettingsCompany;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsCompanyResource extends Resource
{
    protected static ?string $model = SettingsCompany::class;

    protected static ?string $slug = 'settings/companies';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.companies.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.companies.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.companies.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return SettingsCompanyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsCompaniesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettingsCompanies::route('/'),
            'create' => CreateSettingsCompany::route('/create'),
            'edit' => EditSettingsCompany::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
