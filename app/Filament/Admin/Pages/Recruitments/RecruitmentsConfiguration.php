<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Recruitments;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\Recruitments\Configuration\RecruitmentEmploymentTypeResource;
use Filament\Pages\Page;

class RecruitmentsConfiguration extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'recruitments/configuration';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(RecruitmentEmploymentTypeResource::getUrl('index'), navigate: true);
    }
}
