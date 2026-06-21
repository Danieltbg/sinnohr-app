<x-filament-panels::page>
    <style>
        .am-filter-wrap {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 0.5px solid rgb(var(--gray-200));
            background-color: rgb(var(--white));
        }
        .dark .am-filter-wrap {
            border-color: rgba(255,255,255,0.08);
            background-color: rgb(var(--gray-800));
        }
        .am-panel {
            border-radius: 12px;
            border: 0.5px solid rgb(var(--gray-200));
            background-color: rgb(var(--white));
            overflow: hidden;
        }
        .dark .am-panel {
            border-color: rgba(255,255,255,0.08);
            background-color: rgb(var(--gray-800));
        }
        .am-table { width:100%; border-collapse:collapse; }
        .am-table thead tr {
            background: rgb(var(--gray-50));
            border-bottom: 0.5px solid rgb(var(--gray-200));
        }
        .dark .am-table thead tr {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(255,255,255,0.07);
        }
        .am-table th {
            padding: 0.65rem 1rem;
            text-align: left;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgb(var(--gray-400));
        }
        .am-table th:last-child { text-align:right; }
        .am-table td {
            padding: 0.75rem 1rem;
            font-size: 13px;
            color: rgb(var(--gray-700));
            border-bottom: 0.5px solid rgb(var(--gray-100));
            vertical-align: middle;
        }
        .dark .am-table td {
            color: rgb(var(--gray-300));
            border-bottom-color: rgba(255,255,255,0.05);
        }
        .am-table tbody tr:hover td { background: rgb(var(--gray-50)); }
        .dark .am-table tbody tr:hover td { background: rgba(255,255,255,0.03); }
        .am-table tbody tr:last-child td { border-bottom:none; }

        .am-avatar {
            width:28px; height:28px; border-radius:50%;
            background:#E6F1FB;
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:500; color:#185FA5; flex-shrink:0;
        }
        .dark .am-avatar { background:rgba(59,130,246,0.15); color:#93C5FD; }

        .am-project-tag {
            display:inline-flex; align-items:center;
            padding: 2px 8px; border-radius:4px;
            font-size:11px; font-weight:500;
            background:#FAEEDA; color:#854F0B; white-space:nowrap;
        }
        .dark .am-project-tag { background:rgba(245,158,11,0.12); color:#FCD34D; }

        .am-running {
            display:inline-flex; align-items:center; gap:5px;
            padding: 2px 8px; border-radius:20px;
            font-size:11px; font-weight:500;
            background:#E1F5EE; color:#0F6E56;
        }
        .dark .am-running { background:rgba(16,185,129,0.12); color:#6EE7B7; }
        .am-running-dot { width:5px; height:5px; border-radius:50%; background:#1D9E75; display:inline-block; }
        .dark .am-running-dot { background:#6EE7B7; }

        .am-time { font-size:11px; font-variant-numeric:tabular-nums; white-space:nowrap; color:rgb(var(--gray-400)); }
        .dark .am-time { color:rgb(var(--gray-500)); }
        .am-dur { text-align:right; font-size:13px; font-weight:500; font-variant-numeric:tabular-nums; white-space:nowrap; }
    </style>

    {{-- Filter --}}
    <div class="am-filter-wrap mb-4">
        <x-filament::input.wrapper class="w-56">
            <x-filament::input.select wire:model.live="selectedUserId">
                <option value="">All Employees</option>
                @foreach ($this->getUsers() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>

    {{-- Table --}}
    <div class="am-panel">
        <table class="am-table">
            <thead>
            <tr>
                <th>Employee</th>
                <th>Activity</th>
                <th>Project</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th style="text-align:right;">Duration</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($this->getEntries() as $entry)
            <tr>
                <td>
                    <div style="display:flex;align-items:center;gap:8px;">
                        <div class="am-avatar">{{ strtoupper(substr($entry->user->name, 0, 2)) }}</div>
                        <span style="font-weight:500;">{{ $entry->user->name }}</span>
                    </div>
                </td>
                <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                    {{ $entry->description ?: '(no description)' }}
                </td>
                <td>
                    @if ($entry->project?->name)
                    <span class="am-project-tag">{{ $entry->project->name }}</span>
                    @else
                    <span class="text-gray-300 dark:text-gray-600">—</span>
                    @endif
                </td>
                <td class="am-time">
                    {{ $entry->start_time ? $entry->start_time->format('d M Y H:i') : '--' }}
                </td>
                <td class="am-time">
                    @if ($entry->end_time)
                    {{ $entry->end_time->format('d M Y H:i') }}
                    @else
                    <span class="am-running">
                                    <span class="am-running-dot"></span> Running
                                </span>
                    @endif
                </td>
                <td class="am-dur">{{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="padding:2.5rem 1rem;text-align:center;" class="text-gray-400 dark:text-gray-500">
                    No time entries found.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>
    </div>

</x-filament-panels::page>
