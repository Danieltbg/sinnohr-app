<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Attendance;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class AttendanceReporting extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'attendance/reporting';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.attendance.placeholder';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), [
            'placeholderText' => __('filament.attendance.reporting.placeholder'),
        ]);
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.attendance.reporting.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.attendance.reporting.breadcrumb');
    }
}
