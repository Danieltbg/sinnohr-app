<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Applicants\Pages;

use App\Filament\Admin\Resources\Recruitments\Applicants\RecruitmentApplicantResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditRecruitmentApplicant extends EditRecord
{
    protected static string $resource = RecruitmentApplicantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
