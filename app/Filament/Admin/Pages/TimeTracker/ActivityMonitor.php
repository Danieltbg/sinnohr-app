<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Models\TimeEntry;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ActivityMonitor extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $model = TimeEntry::class;

    protected static ?string $slug = 'time-tracker/activity-monitor';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.activity-monitor';

    public ?int $selectedUserId = null;

    public function getTitle(): string|Htmlable
    {
        return 'Activity Monitor';
    }

    public function getBreadcrumb(): string
    {
        return 'Activity Monitor';
    }

    public function getUsers()
    {
        return User::all();
    }

    public function getEntries()
    {
        $query = TimeEntry::with(['user', 'project']);

        if ($this->selectedUserId !== null && $this->selectedUserId !== 0) {
            $query->where('user_id', $this->selectedUserId);
        }

        return $query->latest('start_time')->get();
    }
}
