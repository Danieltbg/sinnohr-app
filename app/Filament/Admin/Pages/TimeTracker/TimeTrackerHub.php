<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;

class TimeTrackerHub extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(Timesheet::getUrl(), navigate: true);
    }
}
