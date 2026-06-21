<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Attendance\MyAttendance;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;

class MyAttendanceHub extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'attendance/my-attendance';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(MyAttendanceDashboard::getUrl(), navigate: true);
    }
}
