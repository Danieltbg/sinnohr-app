<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateSkillType;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditSkillType;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListSkillTypes;
use Filament\Support\Icons\Heroicon;

class SkillTypeResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/skill-types';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedAcademicCap;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::SkillType;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::SkillType->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkillTypes::route('/'),
            'create' => CreateSkillType::route('/create'),
            'edit' => EditSkillType::route('/{record}/edit'),
        ];
    }
}
