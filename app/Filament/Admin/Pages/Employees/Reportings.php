<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Employees;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\EmployeeSkills\EmployeeSkillResource;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Reportings extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'employees/reportings';

    protected static ?string $navigationLabel = null;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedChartBar;

    protected static ?int $navigationSort = 12;

    protected string $view = 'filament.admin.pages.employees.reportings';

    public static function getNavigationLabel(): string
    {
        return __('filament.employees.reportings.navigation');
    }

    public function mount(): void
    {
        $this->redirect(EmployeeSkillResource::getUrl('index'), navigate: true);
    }
}
