<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateWorkLocation;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditWorkLocation;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListWorkLocations;
use Filament\Support\Icons\Heroicon;

class WorkLocationResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/work-locations';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedMapPin;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::WorkLocation;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::WorkLocation->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListWorkLocations::route('/'),
            'create' => CreateWorkLocation::route('/create'),
            'edit' => EditWorkLocation::route('/{record}/edit'),
        ];
    }
}
