<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\CustomFields\Pages;

use App\Filament\Admin\Resources\Settings\CustomFields\SettingsCustomFieldResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSettingsCustomField extends EditRecord
{
    protected static string $resource = SettingsCustomFieldResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
