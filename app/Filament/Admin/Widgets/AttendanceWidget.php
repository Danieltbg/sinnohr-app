<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use Filament\Notifications\Notification;
use Filament\Widgets\Widget;
use Modules\Dashboard\Services\AdminDashboardStatsService;

class AttendanceWidget extends Widget
{
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 4;

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 2,
    ];

    protected string $view = 'filament.admin.widgets.attendance-widget';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            ...app(AdminDashboardStatsService::class)->getAttendanceStatus(),
        ];
    }

    public function checkIn(): void
    {
        Notification::make()
            ->title(__('filament.widgets.attendance.check_in_recorded'))
            ->success()
            ->send();
    }

    public function checkOut(): void
    {
        Notification::make()
            ->title(__('filament.widgets.attendance.check_out_recorded'))
            ->success()
            ->send();
    }
}
