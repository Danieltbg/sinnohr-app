<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams\Pages;

use App\Filament\Admin\Resources\Settings\Teams\SettingsTeamResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSettingsTeam extends CreateRecord
{
    protected static string $resource = SettingsTeamResource::class;
}
