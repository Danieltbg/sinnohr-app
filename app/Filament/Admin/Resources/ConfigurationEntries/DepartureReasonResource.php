<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateDepartureReason;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditDepartureReason;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListDepartureReasons;
use Filament\Support\Icons\Heroicon;

class DepartureReasonResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/departure-reasons';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedArrowRightOnRectangle;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::DepartureReason;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::DepartureReason->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDepartureReasons::route('/'),
            'create' => CreateDepartureReason::route('/create'),
            'edit' => EditDepartureReason::route('/{record}/edit'),
        ];
    }
}
