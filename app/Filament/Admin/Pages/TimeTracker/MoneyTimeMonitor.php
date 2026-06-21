<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Livewire\LiveTimeTracker;
use App\Models\TimeEntry;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MoneyTimeMonitor extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker/money-time';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.money-time-monitor';

    public ?int $filterUserId = null;

    public function getTitle(): string|Htmlable
    {
        return 'Money Time';
    }

    public function getBreadcrumb(): string
    {
        return 'Money Time';
    }

    public function getUsersWithBillable(): mixed
    {
        $userIds = TimeEntry::where('is_billable', true)
            ->distinct()
            ->pluck('user_id');

        return User::whereIn('id', $userIds)->get();
    }

    public function getTotalBillableSeconds(): int
    {
        return (int) TimeEntry::where('is_billable', true)->sum('duration');
    }

    public function getActiveConsultantsCount(): int
    {
        return TimeEntry::where('is_billable', true)
            ->distinct('user_id')
            ->count('user_id');
    }

    public function getUserBillableSummaries(): mixed
    {
        return TimeEntry::where('is_billable', true)
            ->selectRaw('user_id, SUM(duration) as total_seconds')
            ->with('user')
            ->groupBy('user_id')
            ->orderByDesc('total_seconds')
            ->get();
    }

    public function getBillableEntries(): mixed
    {
        $query = TimeEntry::where('is_billable', true)
            ->with(['user', 'project']);

        if ($this->filterUserId !== null && $this->filterUserId !== 0) {
            $query->where('user_id', $this->filterUserId);
        }

        return $query->latest('start_time')->get();
    }

    public static function formatDuration(int $seconds): string
    {
        return LiveTimeTracker::formatDuration($seconds);
    }
}
