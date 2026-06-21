<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Timesheet extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker/timesheet';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.timesheet';

    public function getTitle(): string|Htmlable
    {
        return __('Timesheet');
    }

    public function getBreadcrumb(): string
    {
        return __('Timesheet');
    }
}
