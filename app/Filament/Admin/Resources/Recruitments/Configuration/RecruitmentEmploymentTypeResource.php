<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Configuration;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\BaseConfigurationEntryResource;
use App\Filament\Admin\Resources\Recruitments\Configuration\Pages\CreateRecruitmentEmploymentType;
use App\Filament\Admin\Resources\Recruitments\Configuration\Pages\EditRecruitmentEmploymentType;
use App\Filament\Admin\Resources\Recruitments\Configuration\Pages\ListRecruitmentEmploymentTypes;
use Filament\Support\Icons\Heroicon;

class RecruitmentEmploymentTypeResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'recruitments/configuration/employment-types';

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
            'index' => ListRecruitmentEmploymentTypes::route('/'),
            'create' => CreateRecruitmentEmploymentType::route('/create'),
            'edit' => EditRecruitmentEmploymentType::route('/{record}/edit'),
        ];
    }
}
