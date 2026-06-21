<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateEmploymentType;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditEmploymentType;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListEmploymentTypes;
use Filament\Support\Icons\Heroicon;

class EmploymentTypeResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/employment-types';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::EmploymentType;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::EmploymentType->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEmploymentTypes::route('/'),
            'create' => CreateEmploymentType::route('/create'),
            'edit' => EditEmploymentType::route('/{record}/edit'),
        ];
    }
}
