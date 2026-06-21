<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Employees;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\ActivityPlans\ActivityPlanResource;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class Configurations extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'employees/configurations';

    protected static ?string $navigationLabel = null;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static ?int $navigationSort = 13;

    protected string $view = 'filament.admin.pages.employees.configurations';

    public static function getNavigationLabel(): string
    {
        return __('filament.employees.configurations.navigation');
    }

    public function mount(): void
    {
        $this->redirect(ActivityPlanResource::getUrl('index'), navigate: true);
    }
}
