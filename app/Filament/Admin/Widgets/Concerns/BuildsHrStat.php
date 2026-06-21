<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets\Concerns;

use BackedEnum;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat;

trait BuildsHrStat
{
    /**
     * @param  list<int>|null  $chart
     */
    protected function makeHrStat(
        string $label,
        int|string $value,
        string $description,
        string|BackedEnum|null $icon,
        string $color,
        ?string $trendText = null,
        string|BackedEnum|null $trendIcon = null,
        ?string $trendColor = null,
        ?array $chart = null,
    ): Stat {
        $stat = Stat::make($label, $value)
            ->description($trendText ?? $description)
            ->descriptionIcon($trendIcon ?? Heroicon::ArrowTrendingUp)
            ->icon($icon)
            ->color($trendColor ?? $color);

        if ($chart !== null) {
            $stat->chart($chart);
        }

        return $stat;
    }
}
