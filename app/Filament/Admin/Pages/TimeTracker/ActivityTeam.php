<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Livewire\LiveTimeTracker;
use App\Models\Team;
use App\Models\TimeEntry;
use App\Models\User;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
use UnitEnum;

class ActivityTeam extends Page
{
    use WithPagination;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-users';

    protected static string|UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TIME_TRACKER;

    protected static ?string $slug = 'time-tracker/activity-team';

    protected static ?string $title = 'Activity Team';

    protected string $view = 'filament.admin.pages.time-tracker.activity-team';

    public ?int $selectedUserId = null;

    public ?int $selectedTeamId = null;

    public string $search = '';

    public string $sortColumn = 'start_time';

    public string $sortDirection = 'desc';

    public int $perPage = 10;

    // OPTIMASI: Menggunakan properti publik Livewire untuk mode Admin
    public bool $showAllUsers = false;

    public function getTitle(): string|Htmlable
    {
        return 'Activity Team';
    }

    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user instanceof User && (
            $user->isAdmin() ||
            Team::where('leader_id', $user->id)
                ->where('leader_status', 'accepted')
                ->exists()
        );
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedUserId(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedTeamId(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    // OPTIMASI: Reset halaman saat admin men-toggle data user
    public function updatedShowAllUsers(): void
    {
        $this->resetPage();
    }

    public function getUsers(): Collection
    {
        $memberIds = $this->getScopeUserIds();

        return User::whereIn('id', $memberIds)
            ->orderBy('name')
            ->get();
    }

    public function getTeams(): Collection
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return Team::with('leader')->orderBy('name')->get();
        }

        return Team::with('leader')
            ->where('leader_id', $user->id)
            ->orderBy('name')
            ->get();
    }

    public function getMemberSummaries(): array
    {
        $memberIds = $this->getScopeUserIds();
        $weekStart = Carbon::now('Asia/Jakarta')->startOfWeek();
        $weekEnd = Carbon::now('Asia/Jakarta')->endOfWeek();

        $durations = TimeEntry::whereIn('user_id', $memberIds)
            ->whereBetween('start_time', [$weekStart, $weekEnd])
            ->selectRaw('user_id, COALESCE(SUM(duration), 0) as total_seconds')
            ->groupBy('user_id')
            ->pluck('total_seconds', 'user_id');

        $users = User::whereIn('id', $memberIds)->get()->keyBy('id');

        $summaries = [];
        foreach ($memberIds as $uid) {
            $user = $users->get($uid);
            if ($user === null) {
                continue;
            }

            $seconds = (int) $durations->get($uid, 0);
            $summaries[] = [
                'user' => $user,
                'total_seconds' => $seconds,
                'total_hours' => round($seconds / 3600, 1),
                'formatted' => LiveTimeTracker::formatDuration($seconds),
                'status' => $seconds < 3600 ? 'low' : ($seconds > 28800 ? 'high' : 'ok'),
            ];
        }

        usort($summaries, fn (array $a, array $b): int => $b['total_seconds'] <=> $a['total_seconds']);

        return $summaries;
    }

    public function getTeamMap(): Collection
    {
        $memberIds = $this->getScopeUserIds();

        return DB::table('team_user')
            ->whereIn('user_id', $memberIds)
            ->join('teams', 'team_user.team_id', '=', 'teams.id')
            ->select('team_user.user_id', 'teams.id as team_id', 'teams.name as team_name')
            ->get()
            ->groupBy('user_id');
    }

    public function getEntries()
    {
        $memberIds = $this->getScopeUserIds();

        $query = TimeEntry::with(['user', 'project'])
            ->whereIn('user_id', $memberIds);

        if ($this->selectedUserId !== null && $this->selectedUserId !== 0 && $this->selectedUserId !== '') {
            $query->where('user_id', $this->selectedUserId);
        }

        if ($this->selectedTeamId !== null && $this->selectedTeamId !== 0 && $this->selectedTeamId !== '') {
            $teamMemberIds = DB::table('team_user')
                ->where('team_id', $this->selectedTeamId)
                ->pluck('user_id');

            $query->whereIn('user_id', $teamMemberIds);
        }

        if (! empty($this->search)) {
            $query->where(function ($q) {
                $q->where('description', 'like', '%'.$this->search.'%')
                    ->orWhereHas('project', function ($pq) {
                        $pq->where('name', 'like', '%'.$this->search.'%');
                    })
                    ->orWhereHas('user', function ($uq) {
                        $uq->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        }

        return $query->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);
    }

    public static function formatDuration(int $seconds): string
    {
        return LiveTimeTracker::formatDuration($seconds);
    }

    private function getScopeUserIds(): array
    {
        $user = auth()->user();

        $teamIds = Team::where('leader_id', $user->id)->pluck('id');

        if ($teamIds->isNotEmpty()) {
            $memberIds = DB::table('team_user')
                ->whereIn('team_id', $teamIds)
                ->pluck('user_id')
                ->unique()
                ->push($user->id)
                ->unique()
                ->values()
                ->toArray();

            if ($user->isAdmin() && $this->showAllUsers) {
                return User::pluck('id')->toArray();
            }

            return $memberIds;
        }

        if ($user->isAdmin()) {
            if ($this->showAllUsers) {
                return User::pluck('id')->toArray();
            }

            return DB::table('team_user')
                ->pluck('user_id')
                ->unique()
                ->values()
                ->toArray();
        }

        return [$user->id];
    }
}
