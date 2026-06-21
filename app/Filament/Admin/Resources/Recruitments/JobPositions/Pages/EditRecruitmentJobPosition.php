<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions\Pages;

use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditRecruitmentJobPosition extends EditRecord
{
    protected static string $resource = RecruitmentJobPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
