<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Contracts\Support\Htmlable;

class WeeklyTimeChartWidget extends ChartWidget
{
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 2;

    protected ?string $maxHeight = '300px';

    public ?string $filter = 'weekly';

    public function getHeading(): string|Htmlable|null
    {
        return match ($this->filter) {
            'daily' => 'Today\'s Activity',
            'monthly' => 'Monthly Activity',
            default => 'Weekly Activity',
        };
    }

    protected function getFilters(): ?array
    {
        return [
            'daily' => 'Today',
            'weekly' => 'This Week',
            'monthly' => 'This Month',
        ];
    }

    protected function getData(): array
    {
        $userId = auth()->id();
        $now = now('Asia/Jakarta');
        $dateRange = $this->getDateRange($now);

        $query = TimeEntry::where('user_id', $userId);

        if ($this->filter === 'daily') {
            $query->whereDate('start_time', $now->format('Y-m-d'));
        } elseif ($this->filter === 'monthly') {
            $query->whereBetween('start_time', [
                $now->copy()->startOfYear()->format('Y-m-d 00:00:00'),
                $now->copy()->endOfYear()->format('Y-m-d 23:59:59'),
            ]);
        } else {
            $query->whereBetween('start_time', [
                $dateRange['start']->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d 00:00:00'),
                $dateRange['end']->copy()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d 23:59:59'),
            ]);
        }

        $entries = $query->with('project')->get();
        $labels = $this->getLabels($dateRange);

        $projectTotals = $entries->groupBy('project_id')
            ->map(fn ($group) => $group->sum('duration'))
            ->sortDesc()
            ->take(5);

        $datasets = $this->buildDatasets($entries, $projectTotals, $labels, $dateRange);

        if (empty($datasets)) {
            $datasets[] = [
                'label' => 'No entries',
                'data' => array_fill(0, count($labels), 0),
                'backgroundColor' => 'rgba(156, 163, 175, 0.3)',
                'borderColor' => 'rgb(156, 163, 175)',
                'borderWidth' => 1,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        $now = now('Asia/Jakarta');
        $dateRange = $this->getDateRange($now);

        $query = TimeEntry::where('user_id', auth()->id());
        if ($this->filter === 'daily') {
            $query->whereDate('start_time', $now->format('Y-m-d'));
        } elseif ($this->filter === 'monthly') {
            $query->whereBetween('start_time', [$now->copy()->startOfYear()->format('Y-m-d 00:00:00'), $now->copy()->endOfYear()->format('Y-m-d 23:59:59')]);
        } else {
            $query->whereBetween('start_time', [$dateRange['start']->copy()->startOfWeek(Carbon::MONDAY)->format('Y-m-d 00:00:00'), $dateRange['end']->copy()->endOfWeek(Carbon::SUNDAY)->format('Y-m-d 23:59:59')]);
        }

        $totalSeconds = max(0, (int) $query->sum('duration'));
        $useMinutes = $totalSeconds < 3600;

        return [
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'scales' => [
                'x' => [
                    'stacked' => true,
                    'grid' => ['display' => false],
                ],
                'y' => [
                    'stacked' => true,
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => $useMinutes ? 'Minutes' : 'Hours',
                    ],
                ],
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    private function getDateRange(Carbon $now): array
    {
        return match ($this->filter) {
            'daily' => [
                'start' => $now->copy()->startOfDay(),
                'end' => $now->copy()->endOfDay(),
            ],
            'monthly' => [
                'start' => $now->copy()->startOfYear(),
                'end' => $now->copy()->endOfYear(),
            ],
            default => [
                'start' => $now->copy()->startOfWeek(Carbon::MONDAY),
                'end' => $now->copy()->endOfWeek(Carbon::SUNDAY),
            ],
        };
    }

    private function getLabels(array $dateRange): array
    {
        return match ($this->filter) {
            'daily' => [$dateRange['start']->format('D, M j')],
            'monthly' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            default => array_map(
                fn ($i) => $dateRange['start']->copy()->startOfWeek(Carbon::MONDAY)->addDays($i)->format('D, M j'),
                range(0, 6),
            ),
        };
    }

    private function buildDatasets($entries, $projectTotals, array $labels, array $dateRange): array
    {
        $palette = [
            ['bg' => 'rgba(59, 130, 246, 0.7)', 'border' => 'rgb(59, 130, 246)'],
            ['bg' => 'rgba(16, 185, 129, 0.7)', 'border' => 'rgb(16, 185, 129)'],
            ['bg' => 'rgba(245, 158, 11, 0.7)', 'border' => 'rgb(245, 158, 11)'],
            ['bg' => 'rgba(239, 68, 68, 0.7)', 'border' => 'rgb(239, 68, 68)'],
            ['bg' => 'rgba(168, 85, 247, 0.7)', 'border' => 'rgb(168, 85, 247)'],
        ];

        $datasets = [];
        $colorIndex = 0;

        foreach ($projectTotals as $projectId => $totalDuration) {
            $lookupId = ($projectId === '' || $projectId === null) ? null : (int) $projectId;
            $projectName = $lookupId === null
                ? 'General / No Project'
                : ($entries->firstWhere('project_id', $lookupId)?->project?->name ?? 'Unknown');

            if ($this->filter === 'daily') {
                $data = $this->buildDailyTotalData($entries, $lookupId);
            } elseif ($this->filter === 'monthly') {
                $data = $this->buildMonthlyGroupedData($entries, $lookupId);
            } else {
                $data = $this->buildDayData($entries, $lookupId, $labels, $dateRange['start']->copy()->startOfWeek(Carbon::MONDAY));
            }

            $datasets[] = [
                'label' => $projectName,
                'data' => $data,
                'maxBarThickness' => 45,
                'backgroundColor' => $palette[$colorIndex]['bg'],
                'borderColor' => $palette[$colorIndex]['border'],
                'borderWidth' => 1,
            ];

            $colorIndex = ($colorIndex + 1) % count($palette);
        }

        return $datasets;
    }

    private function buildDailyTotalData($entries, ?int $projectId): array
    {
        $now = now('Asia/Jakarta');
        $totalSecondsAll = (int) TimeEntry::where('user_id', auth()->id())
            ->whereDate('start_time', $now->format('Y-m-d'))
            ->sum('duration');

        $useMinutes = $totalSecondsAll < 3600;
        $seconds = $entries->where('project_id', $projectId)->sum('duration');

        // 🛠️ PEMBATASAN PHP: Langsung dibulatkan 1 angka di belakang koma untuk menit, dan 2 angka untuk jam
        return [$useMinutes ? round($seconds / 60, 1) : round($seconds / 3600, 2)];
    }

    private function buildMonthlyGroupedData($entries, ?int $projectId): array
    {
        $now = now('Asia/Jakarta');
        $totalSecondsAll = (int) TimeEntry::where('user_id', auth()->id())
            ->whereBetween('start_time', [
                $now->copy()->startOfYear()->format('Y-m-d 00:00:00'),
                $now->copy()->endOfYear()->format('Y-m-d 23:59:59'),
            ])->sum('duration');

        $useMinutes = $totalSecondsAll < 3600;

        $data = array_fill(0, 12, 0.0);

        foreach ($entries->where('project_id', $projectId) as $entry) {
            $entryDate = Carbon::parse($entry->start_time);
            $monthIndex = (int) $entryDate->format('n') - 1;

            if ($monthIndex >= 0 && $monthIndex <= 11) {
                $data[$monthIndex] += $entry->duration;
            }
        }

        return array_map(fn ($secs) => $useMinutes ? round($secs / 60, 1) : round($secs / 3600, 2), $data);
    }

    private function buildDayData($entries, ?int $projectId, array $labels, Carbon $startOfWeek): array
    {
        $totalSecondsAll = (int) TimeEntry::where('user_id', auth()->id())
            ->whereBetween('start_time', [
                $startOfWeek->format('Y-m-d 00:00:00'),
                $startOfWeek->copy()->addDays(6)->format('Y-m-d 23:59:59'),
            ])->sum('duration');

        $useMinutes = $totalSecondsAll < 3600;
        $data = [];

        for ($i = 0; $i < 7; $i++) {
            $dateStr = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $seconds = $entries
                ->where('project_id', $projectId)
                ->filter(fn ($e) => Carbon::parse($e->start_time)->format('Y-m-d') === $dateStr)
                ->sum('duration');

            $data[] = $useMinutes ? round($seconds / 60, 1) : round($seconds / 3600, 2);
        }

        return $data;
    }
}
