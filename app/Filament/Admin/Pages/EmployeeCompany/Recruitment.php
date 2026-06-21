<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\EmployeeCompany;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;
use Filament\Pages\Page;

class Recruitment extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'recruitment';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(RecruitmentJobPositionResource::getUrl('index'), navigate: true);
    }
}
