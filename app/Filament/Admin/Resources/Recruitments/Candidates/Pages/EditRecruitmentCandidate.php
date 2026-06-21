<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates\Pages;

use App\Filament\Admin\Resources\Recruitments\Candidates\RecruitmentCandidateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecruitmentCandidate extends EditRecord
{
    protected static string $resource = RecruitmentCandidateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
