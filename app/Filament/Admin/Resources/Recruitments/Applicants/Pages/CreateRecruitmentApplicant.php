<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Applicants\Pages;

use App\Filament\Admin\Resources\Recruitments\Applicants\RecruitmentApplicantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecruitmentApplicant extends CreateRecord
{
    protected static string $resource = RecruitmentApplicantResource::class;
}
