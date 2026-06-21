<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

abstract class EditConfigurationEntry extends EditRecord
{
    public function getTitle(): string | Htmlable
    {
        return __('filament.employees.configurations.entries.edit.title', [
            'name' => $this->getRecord()->name,
        ]);
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.entries.edit.breadcrumb');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
