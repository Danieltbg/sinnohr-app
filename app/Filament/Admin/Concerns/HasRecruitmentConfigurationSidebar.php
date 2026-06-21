<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

trait HasRecruitmentConfigurationSidebar
{
    /**
     * @return array<string, mixed>
     */
    protected function getRecruitmentConfigurationViewData(): array
    {
        $resource = static::getResource();

        return [
            'recruitmentConfigurationActive' => $resource::configurationMenuKey(),
        ];
    }
}
