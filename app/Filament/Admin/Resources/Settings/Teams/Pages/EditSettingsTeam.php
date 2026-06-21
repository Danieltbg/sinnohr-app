<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams\Pages;

use App\Filament\Admin\Resources\Settings\Teams\SettingsTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSettingsTeam extends EditRecord
{
    protected static string $resource = SettingsTeamResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
