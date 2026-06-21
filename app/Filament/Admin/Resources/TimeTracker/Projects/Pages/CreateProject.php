<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects\Pages;

use App\Filament\Admin\Resources\TimeTracker\Projects\ProjectResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;
}
