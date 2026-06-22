<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Filament\Admin\Widgets\Concerns\BuildsHrStat;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Modules\Dashboard\Services\AdminDashboardStatsService;

class ProjectSummaryWidget extends StatsOverviewWidget
{
    use BuildsHrStat;
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 5;

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 2,
        'xl' => 'full',
    ];

    /**
     * @var int | array<string, int|null>|null
     */
    protected int|array|null $columns = [
        'default' => 1,
        'sm' => 2,
    ];

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $service = app(AdminDashboardStatsService::class);
        $stats = $service->getStats();
        $trends = $service->getTrends();
        $sparklines = $service->getSparklines();

        return [
            $this->makeHrStat(
                __('filament.widgets.stats.projects.label'),
                $stats['projects'],
                __('filament.widgets.stats.projects.description'),
                Heroicon::OutlinedSquare3Stack3d,
                'info',
                $trends['projects']['text'],
                $trends['projects']['icon'],
                $trends['projects']['color'],
                $sparklines['projects'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.pending_projects.label'),
                $stats['pending_projects'],
                __('filament.widgets.stats.pending_projects.description'),
                Heroicon::OutlinedSquare3Stack3d,
                'warning',
                $trends['pending_projects']['text'],
                $trends['pending_projects']['icon'],
                $trends['pending_projects']['color'],
                $sparklines['pending_projects'],
            ),
        ];
    }
}
