<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Models\Project;
use App\Models\TimeEntry;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ReportStatsWidget extends StatsOverviewWidget
{
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 1;

    protected int|string|array $columnSpan = 'full';

    protected int|array|null $columns = 3;

    protected function getStats(): array
    {
        $userId = auth()->id();

        $totalSeconds = (int) TimeEntry::where('user_id', $userId)->sum('duration');

        $topProjectData = TimeEntry::where('user_id', $userId)
            ->whereNotNull('project_id')
            ->selectRaw('project_id, SUM(duration) as total_duration')
            ->groupBy('project_id')
            ->orderByDesc('total_duration')
            ->first();

        $topProject = null;
        $topProjectDuration = 0;

        if ($topProjectData !== null) {
            $project = Project::find($topProjectData->project_id);
            $topProject = $project?->name;
            $topProjectDuration = (int) $topProjectData->total_duration;
        }

        $allProjectData = TimeEntry::where('user_id', $userId)
            ->whereNotNull('project_id')
            ->selectRaw('project_id, SUM(duration) as total_duration')
            ->groupBy('project_id')
            ->with('project')
            ->orderByDesc('total_duration')
            ->get();

        $clientDurations = [];
        foreach ($allProjectData as $row) {
            $clientName = $row->project?->client_name ?? 'Unknown';
            $clientDurations[$clientName] = ($clientDurations[$clientName] ?? 0) + (int) $row->total_duration;
        }
        arsort($clientDurations);
        $topClient = array_key_first($clientDurations);

        return [
            Stat::make(
                'Total Time Tracked',
                $totalSeconds > 0 ? $this->formatDuration($totalSeconds) : '--',
            )
                ->description('All tracked hours')
                ->descriptionIcon('heroicon-m-clock')
                ->color('primary')
                ->icon(Heroicon::OutlinedClock),

            Stat::make(
                'Top Project',
                $topProject ?? '--',
            )
                ->description(
                    $topProject !== null
                        ? sprintf('%s tracked', $this->formatDuration($topProjectDuration))
                        : 'No data',
                )
                ->descriptionIcon('heroicon-m-folder')
                ->color('info')
                ->icon(Heroicon::OutlinedFolder),

            Stat::make(
                'Top Client',
                $topClient ?? '--',
            )
                ->description(
                    $topClient !== null
                        ? sprintf('%s tracked', $this->formatDuration($clientDurations[$topClient]))
                        : 'No data',
                )
                ->descriptionIcon('heroicon-m-building-office-2')
                ->color('warning')
                ->icon(Heroicon::OutlinedBuildingOffice2),
        ];
    }

    private function formatDuration(int $seconds): string
    {
        return sprintf(
            '%02d:%02d:%02d',
            intdiv($seconds, 3600),
            intdiv($seconds % 3600, 60),
            $seconds % 60,
        );
    }
}
