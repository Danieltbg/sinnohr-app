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

class LeaveStatsWidget extends StatsOverviewWidget
{
    use BuildsHrStat;
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '15s';

    protected int | string | array $columnSpan = 'full';

    /**
     * @var int | array<string, int|null>|null
     */
    protected int | array | null $columns = [
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
                __('filament.widgets.stats.on_leaves_today.label'),
                $stats['on_leaves_today'],
                __('filament.widgets.stats.on_leaves_today.description'),
                Heroicon::OutlinedClipboardDocument,
                'info',
                $trends['on_leaves_today']['text'],
                $trends['on_leaves_today']['icon'],
                $trends['on_leaves_today']['color'],
                $sparklines['on_leaves_today'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.pending_leaves.label'),
                $stats['pending_leaves'],
                __('filament.widgets.stats.pending_leaves.description'),
                Heroicon::OutlinedBookmark,
                'warning',
                $trends['pending_leaves']['text'],
                $trends['pending_leaves']['icon'],
                $trends['pending_leaves']['color'],
                $sparklines['pending_leaves'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.check_in_today.label'),
                $stats['check_in_today'],
                __('filament.widgets.stats.check_in_today.description'),
                Heroicon::OutlinedArrowRightOnRectangle,
                'success',
                $trends['check_in_today']['text'],
                $trends['check_in_today']['icon'],
                $trends['check_in_today']['color'],
                $sparklines['check_in_today'],
            ),
            $this->makeHrStat(
                __('filament.widgets.stats.check_out_today.label'),
                $stats['check_out_today'],
                __('filament.widgets.stats.check_out_today.description'),
                Heroicon::OutlinedArrowLeftOnRectangle,
                'primary',
                $trends['check_out_today']['text'],
                $trends['check_out_today']['icon'],
                $trends['check_out_today']['color'],
                $sparklines['check_out_today'],
            ),
        ];
    }
}
