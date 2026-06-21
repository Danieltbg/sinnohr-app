<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Livewire\LiveTimeTracker;
use App\Models\Project;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Facades\DB;

class ProjectTeam extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'time-tracker/project-team';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.project-team';

    public function getTitle(): string|Htmlable
    {
        return __('filament.navigation.time_tracker_project_team');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.navigation.time_tracker_project_team');
    }

    public function getProjectTeamData()
    {
        return Project::query()
            ->select([
                'projects.id',
                'projects.name',
                'projects.client_name',
                'projects.team_id',
                DB::raw('COALESCE(SUM(time_entries.duration), 0) as total_duration'),
            ])
            ->leftJoin('time_entries', 'projects.id', '=', 'time_entries.project_id')
            ->with('team.leader')
            ->groupBy('projects.id', 'projects.name', 'projects.client_name', 'projects.team_id')
            ->orderBy('projects.name')
            ->get();
    }

    public static function formatDuration(int $seconds): string
    {
        return LiveTimeTracker::formatDuration($seconds);
    }
}
