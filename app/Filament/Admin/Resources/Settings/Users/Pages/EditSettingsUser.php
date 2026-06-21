<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Users\Pages;

use App\Filament\Admin\Resources\Settings\Users\SettingsUserResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSettingsUser extends EditRecord
{
    protected static string $resource = SettingsUserResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
