<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Pages;

use App\Filament\Admin\Resources\ConfigurationEntries\BaseConfigurationEntryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

abstract class CreateConfigurationEntry extends CreateRecord
{
    public function getTitle(): string|Htmlable
    {
        /** @var BaseConfigurationEntryResource $resource */
        $resource = static::getResource();

        return __('filament.employees.configurations.entries.create.title', [
            'type' => $resource::entryType()->label(),
        ]);
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.entries.create.breadcrumb');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var BaseConfigurationEntryResource $resource */
        $resource = static::getResource();
        $data['type'] = $resource::entryType()->value;
        $data['is_active'] ??= true;

        return $data;
    }
}
