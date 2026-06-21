<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Project;
use App\Models\TimeEntry;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class LiveTimeTracker extends Component
{
    public string $taskDescription = '';

    public bool $isRunning = false;

    public ?string $startedAt = null;

    public string $selectedProject = '';

    public bool $isBillable = false;

    public bool $isOvertime = false;

    public bool $showProjectDropdown = false;

    public string $projectSearch = '';

    public function mount(): void
    {
        $this->restoreTimerState();
    }

    public function startTimer(): void
    {
        $this->isRunning = true;
        $this->startedAt = Carbon::now('Asia/Jakarta')->toISOString();
        $this->saveTimerState();

        $this->dispatch('timer-started', startedAt: $this->startedAt);
    }

    public function stopTimer(): void
    {
        if (! $this->isRunning || $this->startedAt === null) {
            return;
        }

        if (blank($this->taskDescription)) {
            $this->dispatch('timer-continue');

            Notification::make()
                ->title('Cannot stop timer')
                ->body('Please describe what you are working on.')
                ->warning()
                ->send();

            return;
        }

        $start = Carbon::parse($this->startedAt)->setTimezone('Asia/Jakarta');
        $end = Carbon::now('Asia/Jakarta');
        $duration = (int) $start->diffInSeconds($end);

        $this->validate([
            'isBillable' => 'nullable|boolean',
            'isOvertime' => 'nullable|boolean',
        ]);

        $project = Project::where('name', $this->selectedProject)->first();
        $isBillable = $this->isBillable ?? false;
        $isOvertime = $this->isOvertime ?? false;

        TimeEntry::create([
            'user_id' => auth()->id(),
            'project_id' => $project?->id,
            'description' => $this->taskDescription,
            'start_time' => $start,
            'end_time' => $end,
            'duration' => $duration,
            'is_billable' => $isBillable,
            'is_overtime' => $isOvertime,
            'date' => $start->format('Y-m-d'),
        ]);

        $this->isRunning = false;
        $this->startedAt = null;
        $this->taskDescription = '';
        $this->selectedProject = '';
        $this->isBillable = false;
        $this->isOvertime = false;
        $this->saveTimerState();

        Notification::make()
            ->title('Time entry saved')
            ->success()
            ->send();

        $this->dispatch('timer-stopped');
    }

    public function updateEntryTime(string $entryId, string $startTimeStr, string $endTimeStr): void
    {
        if (blank($startTimeStr) || blank($endTimeStr)) {
            return;
        }

        $entry = TimeEntry::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $date = $entry->date instanceof Carbon
            ? $entry->date->format('Y-m-d')
            : now('Asia/Jakarta')->format('Y-m-d');

        $start = Carbon::parse($date.' '.$startTimeStr, 'Asia/Jakarta');
        $end = Carbon::parse($date.' '.$endTimeStr, 'Asia/Jakarta');

        if ($end->lte($start)) {
            $end->addDay();
        }

        $entry->update([
            'start_time' => $start,
            'end_time' => $end,
            'duration' => max((int) $start->diffInSeconds($end), 0),
        ]);

        $this->dispatch('timer-stopped');
    }

    public function updateEntryDate(string $entryId, string $newDateStr): void
    {
        $entry = TimeEntry::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($entry->date?->format('Y-m-d') === $newDateStr) {
            return;
        }

        $entry->update([
            'date' => $newDateStr,
            'start_time' => Carbon::parse($newDateStr.' '.$entry->start_time->format('H:i:s'), 'Asia/Jakarta'),
            'end_time' => Carbon::parse($newDateStr.' '.$entry->end_time->format('H:i:s'), 'Asia/Jakarta'),
        ]);

        $this->dispatch('timer-stopped');
    }

    public function deleteEntry(string $entryId): void
    {
        TimeEntry::where('id', $entryId)
            ->where('user_id', auth()->id())
            ->delete();
    }

    public function restartEntry(string $entryId): void
    {
        $entry = TimeEntry::with('project')
            ->where('id', $entryId)
            ->where('user_id', auth()->id())
            ->first();

        if ($entry === null) {
            return;
        }

        $this->taskDescription = $entry->description ?? '';
        $this->selectedProject = $entry->project_id !== null ? ($entry->project->name ?? '') : '';
        $this->isBillable = $entry->is_billable;
        $this->isOvertime = $entry->is_overtime;
    }

    public function selectProject(string $project): void
    {
        $this->selectedProject = $project;
        $this->showProjectDropdown = false;
        $this->projectSearch = '';
    }

    public function updatedProjectSearch(): void
    {
        $this->showProjectDropdown = true;
    }

    public function render(): View
    {
        $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $yesterday = Carbon::now('Asia/Jakarta')->subDay()->format('Y-m-d');

        $entries = TimeEntry::with('project')
            ->where('user_id', auth()->id())
            ->orderBy('start_time', 'desc')
            ->get();

        $grouped = [];
        foreach ($entries as $entry) {
            $dateKey = $entry->date?->format('Y-m-d') ?? 'unknown';

            if (! isset($grouped[$dateKey])) {
                $grouped[$dateKey] = [
                    'label' => $this->dateLabel($dateKey, $today, $yesterday),
                    'date' => $dateKey,
                    'total' => 0,
                    'entries' => [],
                ];
            }

            $grouped[$dateKey]['total'] += $entry->duration;
            $grouped[$dateKey]['entries'][] = $entry;
        }

        foreach ($grouped as $dateKey => $group) {
            $grouped[$dateKey]['total_formatted'] = self::formatDuration($group['total']);
        }

        $projectNames = Project::pluck('name')->toArray();

        $filteredProjects = $this->projectSearch === ''
            ? $projectNames
            : array_values(array_filter(
                $projectNames,
                fn (string $p): bool => str_contains(strtolower($p), strtolower($this->projectSearch)),
            ));

        return view('livewire.live-time-tracker', [
            'groupedEntries' => $grouped,
            'filteredProjects' => $filteredProjects,
        ]);
    }

    public static function formatDuration(int $seconds): string
    {
        return sprintf(
            '%02d:%02d:%02d',
            intdiv($seconds, 3600),
            intdiv($seconds % 3600, 60),
            $seconds % 60,
        );
    }

    private function dateLabel(string $dateKey, string $today, string $yesterday): string
    {
        if ($dateKey === $today) {
            return 'Today';
        }

        if ($dateKey === $yesterday) {
            return 'Yesterday';
        }

        return Carbon::parse($dateKey)->format('D, M j');
    }

    private function saveTimerState(): void
    {
        session()->put('time_tracker_running', $this->isRunning);
        session()->put('time_tracker_started_at', $this->startedAt);
        session()->put('time_tracker_description', $this->taskDescription);
        session()->put('time_tracker_project', $this->selectedProject);
        session()->put('time_tracker_billable', $this->isBillable);
        session()->put('time_tracker_overtime', $this->isOvertime);
    }

    private function restoreTimerState(): void
    {
        $this->isRunning = (bool) session()->get('time_tracker_running', false);
        $this->startedAt = session()->get('time_tracker_started_at');
        $this->taskDescription = (string) session()->get('time_tracker_description', '');
        $this->selectedProject = (string) session()->get('time_tracker_project', '');
        $this->isBillable = (bool) session()->get('time_tracker_billable', false);
        $this->isOvertime = (bool) session()->get('time_tracker_overtime', false);
    }
}
