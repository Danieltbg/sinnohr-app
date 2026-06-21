<?php

declare(strict_types=1);

namespace Modules\Dashboard\Services;

use Filament\Support\Icons\Heroicon;
use Modules\Dashboard\Repositories\AdminDashboardStatsRepository;

class AdminDashboardStatsService
{
    public function __construct(
        private readonly AdminDashboardStatsRepository $repository,
    ) {}

    /**
     * @return array<string, int>
     */
    public function getStats(): array
    {
        return $this->repository->getStats();
    }

    /**
     * @return array<string, array{text: string, color: string, icon: Heroicon}>
     */
    public function getTrends(): array
    {
        return [
            'employees' => [
                'text' => __('filament.widgets.trends.employees'),
                'color' => 'success',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'departments' => [
                'text' => __('filament.widgets.trends.departments'),
                'color' => 'success',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'holidays' => [
                'text' => __('filament.widgets.trends.holidays'),
                'color' => 'warning',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'paid_leaves' => [
                'text' => __('filament.widgets.trends.paid_leaves'),
                'color' => 'danger',
                'icon' => Heroicon::ArrowTrendingDown,
            ],
            'on_leaves_today' => [
                'text' => __('filament.widgets.trends.on_leaves_today'),
                'color' => 'warning',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'pending_leaves' => [
                'text' => __('filament.widgets.trends.pending_leaves'),
                'color' => 'warning',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'check_in_today' => [
                'text' => __('filament.widgets.trends.check_in_today'),
                'color' => 'success',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'check_out_today' => [
                'text' => __('filament.widgets.trends.check_out_today'),
                'color' => 'info',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'projects' => [
                'text' => __('filament.widgets.trends.projects'),
                'color' => 'success',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
            'pending_projects' => [
                'text' => __('filament.widgets.trends.pending_projects'),
                'color' => 'warning',
                'icon' => Heroicon::ArrowTrendingUp,
            ],
        ];
    }

    /**
     * @return array<string, list<int>>
     */
    public function getSparklines(): array
    {
        return [
            'employees' => [118, 120, 122, 123, 125, 126, 128],
            'departments' => [10, 10, 11, 11, 11, 12, 12],
            'holidays' => [14, 15, 16, 16, 17, 17, 18],
            'paid_leaves' => [252, 248, 245, 244, 242, 241, 240],
            'on_leaves_today' => [4, 5, 6, 5, 6, 7, 7],
            'pending_leaves' => [18, 17, 16, 15, 15, 14, 14],
            'check_in_today' => [102, 105, 108, 110, 112, 114, 115],
            'check_out_today' => [88, 90, 92, 94, 96, 97, 98],
            'projects' => [18, 19, 20, 21, 22, 23, 24],
            'pending_projects' => [9, 8, 8, 7, 7, 6, 6],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttendanceStatus(): array
    {
        $status = $this->repository->getAttendanceStatus();

        return [
            ...$status,
            'status' => match ($status['status'] ?? '') {
                'Checked in' => __('filament.widgets.attendance.checked_in'),
                'Not checked in' => __('filament.widgets.attendance.not_checked_in'),
                default => $status['status'] ?? __('filament.widgets.attendance.not_checked_in'),
            },
        ];
    }

    /**
     * @return array<string, list<int>>
     */
    public function getProjectChartData(): array
    {
        return $this->repository->getProjectChartData();
    }
}
