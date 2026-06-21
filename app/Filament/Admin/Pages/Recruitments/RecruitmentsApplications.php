<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Recruitments;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;
use Filament\Pages\Page;

class RecruitmentsApplications extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'recruitments/applications';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(RecruitmentJobPositionResource::getUrl('index'), navigate: true);
    }
}
