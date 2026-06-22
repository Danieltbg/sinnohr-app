<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Modules\Dashboard\Services\AdminDashboardStatsService;

class ProjectChartWidget extends ChartWidget
{
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 3;

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = [
        'default' => 1,
        'md' => 1,
        'xl' => 2,
    ];

    protected ?string $maxHeight = '250px';

    public function getHeading(): ?string
    {
        return __('filament.widgets.project_chart.heading');
    }

    protected function getData(): array
    {
        $chart = app(AdminDashboardStatsService::class)->getProjectChartData();

        return [
            'datasets' => [
                [
                    'label' => __('filament.widgets.project_chart.completed'),
                    'data' => $chart['completed'],
                    'borderColor' => 'rgb(59, 130, 246)',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
                [
                    'label' => __('filament.widgets.project_chart.in_progress'),
                    'data' => $chart['in_progress'],
                    'borderColor' => 'rgb(96, 165, 250)',
                    'backgroundColor' => 'rgba(96, 165, 250, 0.12)',
                    'fill' => true,
                    'tension' => 0.35,
                ],
            ],
            'labels' => $chart['labels'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
