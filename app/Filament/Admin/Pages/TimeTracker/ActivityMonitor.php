<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeTracker;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Models\TimeEntry;
use App\Models\User;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Livewire\WithPagination;

class ActivityMonitor extends Page
{
    use RegistersAdminNavigation, WithPagination;

    protected static ?string $model = TimeEntry::class;

    protected static ?string $slug = 'time-tracker/activity-monitor';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.time-tracker.activity-monitor';

    public ?int $selectedUserId = null;

    public ?int $selectedDepartmentId = null;

    public string $search = '';

    public string $sortColumn = 'start_time';

    public string $sortDirection = 'desc';

    public int $perPage = 10;

    public function mount(): void
    {
        $deptId = request()->query('department');

        if ($deptId !== null && $deptId !== '' && $deptId !== '0') {
            $this->selectedDepartmentId = (int) $deptId;
        }
    }

    public function getTitle(): string|Htmlable
    {
        return 'Activity Monitor';
    }

    public function getBreadcrumb(): string
    {
        return 'Activity Monitor';
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedDepartmentId(): void
    {
        $this->resetPage();
    }

    public function updatedSelectedUserId(): void
    {
        $this->resetPage();
    }

    public function updatedPerPage(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }

    public function getUsers()
    {
        $query = User::query();

        if ($this->selectedDepartmentId !== null && $this->selectedDepartmentId !== 0 && $this->selectedDepartmentId !== '') {
            $query->where('master_department_id', $this->selectedDepartmentId);
        }

        return $query->get();
    }

    public function getEntries()
    {
        $query = TimeEntry::with(['user', 'project'])
            ->where('approval_status', 'approved');

        // 1. Filter Berdasarkan Karyawan Terpilih
        if ($this->selectedUserId !== null && $this->selectedUserId !== 0 && $this->selectedUserId !== '') {
            $query->where('user_id', $this->selectedUserId);
        }

        if ($this->selectedDepartmentId !== null && $this->selectedDepartmentId !== 0 && $this->selectedDepartmentId !== '') {
            $query->whereHas('user', function ($q) {
                $q->where('master_department_id', $this->selectedDepartmentId);
            });
        }

        // 3. Filter Live Search (Aktivitas / Nama Proyek)
        if (! empty($this->search)) {
            $query->where(function ($searchQuery) {
                $searchQuery->where('description', 'like', '%'.$this->search.'%')
                    ->orWhereHas('project', function ($q) {
                        $q->where('name', 'like', '%'.$this->search.'%');
                    });
            });
        }

        return $query->orderBy($this->sortColumn, $this->sortDirection)->paginate($this->perPage);
    }
}
