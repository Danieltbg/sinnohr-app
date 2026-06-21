<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies\Pages;

use App\Filament\Admin\Resources\Settings\Companies\SettingsCompanyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSettingsCompany extends EditRecord
{
    protected static string $resource = SettingsCompanyResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
