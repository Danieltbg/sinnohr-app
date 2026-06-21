<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

trait HasRecruitmentApplicationsSidebar
{
    /**
     * @return array<string, mixed>
     */
    protected function getRecruitmentApplicationsViewData(): array
    {
        $resource = static::getResource();

        return [
            'recruitmentApplicationsActive' => $resource::applicationsMenuKey(),
        ];
    }
}
