<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\CustomFields\Pages;

use App\Filament\Admin\Resources\Settings\CustomFields\SettingsCustomFieldResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSettingsCustomField extends CreateRecord
{
    protected static string $resource = SettingsCustomFieldResource::class;
}
