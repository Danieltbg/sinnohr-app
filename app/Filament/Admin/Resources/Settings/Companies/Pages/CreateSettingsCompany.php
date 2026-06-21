<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies\Pages;

use App\Filament\Admin\Resources\Settings\Companies\SettingsCompanyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSettingsCompany extends CreateRecord
{
    protected static string $resource = SettingsCompanyResource::class;
}
