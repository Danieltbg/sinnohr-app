<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\CustomFields;

use App\Filament\Admin\Resources\Settings\CustomFields\Pages\CreateSettingsCustomField;
use App\Filament\Admin\Resources\Settings\CustomFields\Pages\EditSettingsCustomField;
use App\Filament\Admin\Resources\Settings\CustomFields\Pages\ListSettingsCustomFields;
use App\Filament\Admin\Resources\Settings\CustomFields\Schemas\SettingsCustomFieldForm;
use App\Filament\Admin\Resources\Settings\CustomFields\Tables\SettingsCustomFieldsTable;
use App\Models\SettingsCustomField;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SettingsCustomFieldResource extends Resource
{
    protected static ?string $model = SettingsCustomField::class;

    protected static ?string $slug = 'settings/custom-fields';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedAdjustmentsHorizontal;

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.custom_fields.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('filament.settings.custom_fields.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('filament.settings.custom_fields.plural');
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return SettingsCustomFieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SettingsCustomFieldsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSettingsCustomFields::route('/'),
            'create' => CreateSettingsCustomField::route('/create'),
            'edit' => EditSettingsCustomField::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([SoftDeletingScope::class]);
    }
}
