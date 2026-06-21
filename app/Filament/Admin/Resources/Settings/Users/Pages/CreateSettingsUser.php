<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Users\Pages;

use App\Filament\Admin\Resources\Settings\Users\SettingsUserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSettingsUser extends CreateRecord
{
    protected static string $resource = SettingsUserResource::class;
}
