<x-filament-panels::page>
    <style>
        .mt-stat-card {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 1rem 1.25rem;
            border-radius: 12px;
            border: 0.5px solid rgb(var(--gray-200));
            background-color: rgb(var(--white));
        }
        .dark .mt-stat-card {
            border-color: rgba(255,255,255,0.08);
            background-color: rgb(var(--gray-800));
        }
        .mt-icon-amber { width:38px; height:38px; border-radius:8px; background:#FAEEDA; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .mt-icon-teal  { width:38px; height:38px; border-radius:8px; background:#E1F5EE; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .mt-icon-blue  { width:38px; height:38px; border-radius:8px; background:#E6F1FB; display:flex; align-items:center; justify-content:center; flex-shrink:0; }
        .dark .mt-icon-amber { background: rgba(234,179,8,0.12); }
        .dark .mt-icon-teal  { background: rgba(20,184,166,0.12); }
        .dark .mt-icon-blue  { background: rgba(59,130,246,0.12); }
        .mt-stat-label {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgb(var(--gray-400));
            margin-bottom: 3px;
        }
        .mt-stat-value {
            font-size: 20px;
            font-weight: 500;
            letter-spacing: -0.5px;
            font-variant-numeric: tabular-nums;
            color: rgb(var(--gray-900));
        }
        .dark .mt-stat-value { color: rgb(var(--gray-100)); }

        .mt-panel {
            border-radius: 12px;
            border: 0.5px solid rgb(var(--gray-200));
            background-color: rgb(var(--white));
            overflow: hidden;
        }
        .dark .mt-panel {
            border-color: rgba(255,255,255,0.08);
            background-color: rgb(var(--gray-800));
        }
        .mt-panel-header {
            padding: 0.75rem 1rem;
            border-bottom: 0.5px solid rgb(var(--gray-200));
        }
        .dark .mt-panel-header {
            border-bottom-color: rgba(255,255,255,0.07);
        }
        .mt-panel-header span {
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: rgb(var(--gray-400));
        }

        .mt-summary-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.65rem 1rem;
            border-bottom: 0.5px solid rgb(var(--gray-100));
            transition: background 75ms;
        }
        .dark .mt-summary-row { border-bottom-color: rgba(255,255,255,0.05); }
        .mt-summary-row:hover { background: rgb(var(--gray-50)); }
        .dark .mt-summary-row:hover { background: rgba(255,255,255,0.04); }

        .mt-avatar {
            width:28px; height:28px; border-radius:50%;
            background:#E6F1FB;
            display:flex; align-items:center; justify-content:center;
            font-size:10px; font-weight:500; color:#185FA5; flex-shrink:0;
        }
        .dark .mt-avatar { background:rgba(59,130,246,0.15); color:#93C5FD; }

        .mt-emp-name { font-size:13px; color:rgb(var(--gray-700)); }
        .dark .mt-emp-name { color:rgb(var(--gray-200)); }
        .mt-duration-sm { font-size:12px; font-weight:500; font-variant-numeric:tabular-nums; color:rgb(var(--gray-500)); }
        .dark .mt-duration-sm { color:rgb(var(--gray-400)); }

        .mt-table { width:100%; border-collapse:collapse; }
        .mt-table thead tr {
            background: rgb(var(--gray-50));
            border-bottom: 0.5px solid rgb(var(--gray-200));
        }
        .dark .mt-table thead tr {
            background: rgba(255,255,255,0.03);
            border-bottom-color: rgba(255,255,255,0.07);
        }
        .mt-table th {
            padding: 0.65rem 1rem;
            text-align: left;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: rgb(var(--gray-400));
        }
        .mt-table th:last-child { text-align:right; }
        .mt-table td {
            padding: 0.7rem 1rem;
            font-size: 13px;
            color: rgb(var(--gray-700));
            border-bottom: 0.5px solid rgb(var(--gray-100));
            vertical-align: middle;
        }
        .dark .mt-table td {
            color: rgb(var(--gray-300));
            border-bottom-color: rgba(255,255,255,0.05);
        }
        .mt-table tbody tr:hover td { background: rgb(var(--gray-50)); }
        .dark .mt-table tbody tr:hover td { background: rgba(255,255,255,0.03); }
        .mt-table tbody tr:last-child td { border-bottom:none; }

        .mt-project-tag {
            display:inline-flex; align-items:center;
            padding: 2px 8px; border-radius:4px;
            font-size:11px; font-weight:500;
            background:#FAEEDA; color:#854F0B; white-space:nowrap;
        }
        .dark .mt-project-tag { background:rgba(245,158,11,0.12); color:#FCD34D; }

        .mt-time { font-size:11px; font-variant-numeric:tabular-nums; white-space:nowrap; color:rgb(var(--gray-400)); }
        .dark .mt-time { color:rgb(var(--gray-500)); }
        .mt-dur { text-align:right; font-size:13px; font-weight:500; font-variant-numeric:tabular-nums; white-space:nowrap; }

        .mt-filter-wrap {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            border: 0.5px solid rgb(var(--gray-200));
            background-color: rgb(var(--white));
        }
        .dark .mt-filter-wrap {
            border-color: rgba(255,255,255,0.08);
            background-color: rgb(var(--gray-800));
        }
    </style>

    {{-- Top Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 mb-4">

        <div class="mt-stat-card">
            <div class="mt-icon-amber">
                <x-filament::icon icon="heroicon-o-currency-dollar" class="w-5 h-5 text-amber-700 dark:text-amber-400" />
            </div>
            <div>
                <p class="mt-stat-label">Total Billable Hours</p>
                <p class="mt-stat-value">{{ \App\Livewire\LiveTimeTracker::formatDuration($this->getTotalBillableSeconds()) }}</p>
            </div>
        </div>

        <div class="mt-stat-card">
            <div class="mt-icon-teal">
                <x-filament::icon icon="heroicon-o-users" class="w-5 h-5 text-teal-700 dark:text-teal-400" />
            </div>
            <div>
                <p class="mt-stat-label">Active Consultants</p>
                <p class="mt-stat-value">{{ $this->getActiveConsultantsCount() }}</p>
            </div>
        </div>

        <div class="mt-stat-card">
            <div class="mt-icon-blue">
                <x-filament::icon icon="heroicon-o-clock" class="w-5 h-5 text-blue-700 dark:text-blue-400" />
            </div>
            <div>
                <p class="mt-stat-label">Average Per Consultant</p>
                <p class="mt-stat-value">
                    @php
                    $count = $this->getActiveConsultantsCount();
                    $avg = $count > 0 ? intdiv($this->getTotalBillableSeconds(), $count) : 0;
                    @endphp
                    {{ \App\Livewire\LiveTimeTracker::formatDuration($avg) }}
                </p>
            </div>
        </div>

    </div>

    {{-- Filter --}}
    <div class="mt-filter-wrap mb-4">
        <x-filament::input.wrapper class="w-56">
            <x-filament::input.select wire:model.live="filterUserId">
                <option value="">All Employees (Billable)</option>
                @foreach ($this->getUsersWithBillable() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </x-filament::input.select>
        </x-filament::input.wrapper>
    </div>

    {{-- Main Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-3">

        {{-- Left: Billable Summary --}}
        <div class="lg:col-span-1 mt-panel">
            <div class="mt-panel-header"><span>Billable Summary</span></div>
            @forelse ($this->getUserBillableSummaries() as $summary)
            <div class="mt-summary-row">
                <div style="display:flex;align-items:center;gap:8px;min-width:0;">
                    <div class="mt-avatar">{{ strtoupper(substr($summary->user->name, 0, 2)) }}</div>
                    <span class="mt-emp-name" style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $summary->user->name }}</span>
                </div>
                <span class="mt-duration-sm" style="flex-shrink:0;margin-left:8px;">
                        {{ \App\Livewire\LiveTimeTracker::formatDuration((int) $summary->total_seconds) }}
                    </span>
            </div>
            @empty
            <div style="padding:2rem 1rem;text-align:center;font-size:13px;" class="text-gray-400 dark:text-gray-500">No billable entries yet.</div>
            @endforelse
        </div>

        {{-- Right: Billable Entries --}}
        <div class="lg:col-span-2 mt-panel">
            <div class="mt-panel-header">
                <span>
                    Billable Entries
                    @if ($this->filterUserId)
                        @php $filteredUser = \App\Models\User::find($this->filterUserId); @endphp
                        @if ($filteredUser)
                            &mdash; <span style="font-weight:400;text-transform:none;letter-spacing:0;" class="text-gray-500 dark:text-gray-400">{{ $filteredUser->name }}</span>
                        @endif
                    @endif
                </span>
            </div>
            <table class="mt-table">
                <thead>
                <tr>
                    <th>Employee</th>
                    <th>Activity</th>
                    <th>Project</th>
                    <th>Time Range</th>
                    <th style="text-align:right;">Duration</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($this->getBillableEntries() as $entry)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <div class="mt-avatar">{{ strtoupper(substr($entry->user->name, 0, 2)) }}</div>
                            <span style="font-weight:500;">{{ $entry->user->name }}</span>
                        </div>
                    </td>
                    <td style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                        {{ $entry->description ?: '(no description)' }}
                    </td>
                    <td>
                        @if ($entry->project)
                        <span class="mt-project-tag">{{ $entry->project->name }}</span>
                        @else
                        <span class="text-gray-300 dark:text-gray-600">—</span>
                        @endif
                    </td>
                    <td class="mt-time">
                        {{ $entry->start_time?->format('H:i') ?? '--:--' }} – {{ $entry->end_time?->format('H:i') ?? '--:--' }}
                    </td>
                    <td class="mt-dur">{{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}</td>
                </tr>
                @empty
                <tr><td colspan="5" style="padding:2rem 1rem;text-align:center;" class="text-gray-400 dark:text-gray-500">No billable time entries found.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-filament-panels::page>
