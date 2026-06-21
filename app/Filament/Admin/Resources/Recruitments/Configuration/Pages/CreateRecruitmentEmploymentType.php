<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Configuration\Pages;

use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateConfigurationEntry;

class CreateRecruitmentEmploymentType extends CreateConfigurationEntry
{
    protected static string $resource = \App\Filament\Admin\Resources\Recruitments\Configuration\RecruitmentEmploymentTypeResource::class;
}
