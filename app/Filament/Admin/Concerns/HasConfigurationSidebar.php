<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

trait HasConfigurationSidebar
{
    /**
     * @return array<string, mixed>
     */
    protected function getConfigurationViewData(): array
    {
        $resource = static::getResource();

        return [
            'configurationActive' => $resource::configurationMenuKey(),
        ];
    }
}
