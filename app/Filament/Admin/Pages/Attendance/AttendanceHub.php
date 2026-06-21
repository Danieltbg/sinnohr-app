<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Attendance;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Pages\Attendance\MyAttendance\MyAttendanceDashboard;
use Filament\Pages\Page;

class AttendanceHub extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'attendance';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(MyAttendanceDashboard::getUrl(), navigate: true);
    }
}
