<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions\Pages;

use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecruitmentJobPosition extends CreateRecord
{
    protected static string $resource = RecruitmentJobPositionResource::class;
}
