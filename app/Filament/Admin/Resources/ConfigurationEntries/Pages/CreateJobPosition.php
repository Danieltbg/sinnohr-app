<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Pages;

use App\Filament\Admin\Resources\ConfigurationEntries\JobPositionResource;

class CreateJobPosition extends CreateConfigurationEntry
{
    protected static string $resource = JobPositionResource::class;
}

