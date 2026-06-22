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

class EmployeeStatsWidget extends StatsOverviewWidget
{
    use BuildsHrStat;
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = 'full';

    /**
     * @var int | array<string, int|null>|null
     */
    protected int|array|null $columns = [
        'default' => 1,
        'sm' => 2,
        'lg' => 4,
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
                __('filament.widgets.stats.employees.label'),
                $stats['employees'],
                __('filament.widgets.stats.employees.description'),
                Heroicon::OutlinedUsers,
                'info',
                $trends['employees']['text'],
                $trends['employees']['icon'],
                $trends['employees']['color'],
                $sparklines['employees'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.departments.label'),
                $stats['departments'],
                __('filament.widgets.stats.departments.description'),
                Heroicon::OutlinedSquare3Stack3d,
                'success',
                $trends['departments']['text'],
                $trends['departments']['icon'],
                $trends['departments']['color'],
                $sparklines['departments'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.holidays.label'),
                $stats['holidays'],
                __('filament.widgets.stats.holidays.description'),
                Heroicon::OutlinedSun,
                'warning',
                $trends['holidays']['text'],
                $trends['holidays']['icon'],
                $trends['holidays']['color'],
                $sparklines['holidays'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.paid_leaves.label'),
                $stats['paid_leaves'],
                __('filament.widgets.stats.paid_leaves.description'),
                Heroicon::OutlinedDocumentText,
                'primary',
                $trends['paid_leaves']['text'],
                $trends['paid_leaves']['icon'],
                $trends['paid_leaves']['color'],
                $sparklines['paid_leaves'],
            ),
        ];
    }
}
