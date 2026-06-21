<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Schemas\ConfigurationEntryForm;
use App\Filament\Admin\Resources\ConfigurationEntries\Tables\ConfigurationEntriesTable;
use App\Models\EmployeeConfigurationEntry;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

abstract class BaseConfigurationEntryResource extends Resource
{
    protected static ?string $model = EmployeeConfigurationEntry::class;

    abstract public static function entryType(): ConfigurationEntryTypeEnum;

    abstract public static function configurationMenuKey(): string;

    public static function getNavigationLabel(): string
    {
        return static::entryType()->label();
    }

    public static function getModelLabel(): string
    {
        return static::entryType()->label();
    }

    public static function getPluralModelLabel(): string
    {
        return static::entryType()->label();
    }

    public static function shouldRegisterNavigation(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function form(Schema $schema): Schema
    {
        return ConfigurationEntryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConfigurationEntriesTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', static::entryType()->value);
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->where('type', static::entryType()->value);
    }
}
