<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateJobPosition;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditJobPosition;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListJobPositions;
use Filament\Support\Icons\Heroicon;

class JobPositionResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/job-positions';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedUserCircle;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::JobPosition;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::JobPosition->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListJobPositions::route('/'),
            'create' => CreateJobPosition::route('/create'),
            'edit' => EditJobPosition::route('/{record}/edit'),
        ];
    }
}
