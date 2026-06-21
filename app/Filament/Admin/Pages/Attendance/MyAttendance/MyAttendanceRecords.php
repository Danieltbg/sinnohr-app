<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Attendance\MyAttendance;

use App\Filament\Admin\Concerns\InteractsWithAttendanceSidebar;
use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MyAttendanceRecords extends Page
{
    use InteractsWithAttendanceSidebar;
    use RegistersAdminNavigation;

    protected static ?string $slug = 'attendance/my-attendance/records';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.attendance.my-attendance.placeholder';

    public static function attendanceMenuKey(): string
    {
        return 'records';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getAttendanceSidebarViewData(), [
            'placeholderText' => __('filament.attendance.my_attendance.records.placeholder'),
        ]);
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.attendance.my_attendance.records.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.attendance.my_attendance.records.breadcrumb');
    }
}
