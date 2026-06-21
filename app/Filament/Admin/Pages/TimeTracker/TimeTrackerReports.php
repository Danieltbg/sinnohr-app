<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Widgets\DetailedTimeEntriesWidget;
use App\Filament\Admin\Widgets\ReportStatsWidget;
use App\Filament\Admin\Widgets\TopActivitiesWidget;
use App\Filament\Admin\Widgets\WeeklyTimeChartWidget;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class TimeTrackerReports extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker/reports';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.reports';

    public ?string $activeTab = null;

    public function mount(): void
    {
        $this->activeTab ??= 'summary';
    }

    // 👇 UBAH DI SINI: Langsung return teks biasa agar tidak memanggil file bahasa
    public function getTitle(): string|Htmlable
    {
        return 'Reports';
    }

    // 👇 UBAH DI SINI JUGA
    public function getBreadcrumb(): string
    {
        return 'Reports';
    }

    public function getHeaderWidgetsColumns(): int|array
    {
        return 3;
    }

    public function getHeaderWidgets(): array
    {
        return [];
    }

    public function getFooterWidgetsColumns(): int|array
    {
        return 3;
    }

    public function getFooterWidgets(): array
    {
        return match ($this->activeTab) {
            'summary' => [
                ReportStatsWidget::class,
                TopActivitiesWidget::class,
            ],
            'detailed' => [
                ReportStatsWidget::class,
                DetailedTimeEntriesWidget::class,
            ],
            'weekly' => [
                ReportStatsWidget::class,
                WeeklyTimeChartWidget::class,
            ],
            default => [
                ReportStatsWidget::class,
                TopActivitiesWidget::class,
            ],
        };
    }

    public function getTabs(): array
    {
        return [
            'summary' => __('Summary'),
            'detailed' => __('Detailed'),
            'weekly' => __('Weekly'),
        ];
    }
}
