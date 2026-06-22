<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Pages;

use App\Filament\Admin\Resources\ConfigurationEntries\EmploymentTypeResource;

class CreateEmploymentType extends CreateConfigurationEntry
{
    protected static string $resource = EmploymentTypeResource::class;
}
