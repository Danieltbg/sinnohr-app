<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates\Pages;

use App\Filament\Admin\Resources\Recruitments\Candidates\RecruitmentCandidateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateRecruitmentCandidate extends CreateRecord
{
    protected static string $resource = RecruitmentCandidateResource::class;
}
