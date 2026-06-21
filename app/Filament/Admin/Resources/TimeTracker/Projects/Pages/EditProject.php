<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects\Pages;

use App\Filament\Admin\Resources\TimeTracker\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
