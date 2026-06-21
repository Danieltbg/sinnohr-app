<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Livewire\LiveTimeTracker;
use App\Models\TimeEntry;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class Overtime extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker/overtime';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.overtime';

    public function getTitle(): string|Htmlable
    {
        return __('filament.navigation.time_tracker_overtime');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.navigation.time_tracker_overtime');
    }

    public function getOvertimeEntries()
    {
        return TimeEntry::with('project')
            ->where('user_id', auth()->id())
            ->where('is_overtime', true)
            ->orderBy('start_time', 'desc')
            ->get();
    }

    public function getTotalOvertimeSeconds(): int
    {
        return (int) TimeEntry::where('user_id', auth()->id())
            ->where('is_overtime', true)
            ->sum('duration');
    }

    public static function formatDuration(int $seconds): string
    {
        return LiveTimeTracker::formatDuration($seconds);
    }
}
