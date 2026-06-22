<x-filament-panels::page>
    {{-- Header --}}

    {{-- Member Weekly Summary Cards --}}
    @php $summaries = $this->getMemberSummaries() @endphp
    @if (! empty($summaries))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @foreach ($summaries as $summary)
        <div class="relative overflow-hidden rounded-xl bg-white dark:bg-gray-900 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 p-4 transition-all duration-200 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 flex items-center justify-center text-xs font-bold text-gray-600 dark:text-gray-300 shrink-0">
                        {{ strtoupper(substr($summary['user']->name ?? '?', 0, 2)) }}
                    </div>
                    <div class="min-w-0">
                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100 truncate">{{ $summary['user']->name }}</p>
                        <p class="text-[11px] text-gray-400 dark:text-gray-500">This week</p>
                    </div>
                </div>
                <span @class([
                    'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider',
                    'bg-rose-50 text-rose-600 dark:bg-rose-500/10 dark:text-rose-400' => $summary['status'] === 'low',
                    'bg-emerald-50 text-emerald-600 dark:bg-emerald-500/10 dark:text-emerald-400' => $summary['status'] === 'ok',
                    'bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400' => $summary['status'] === 'high',
                ])>
                    {{ $summary['status'] === 'low' ? 'Low' : ($summary['status'] === 'high' ? 'High' : 'OK') }}
                </span>
            </div>
            <div class="mt-3 flex items-baseline gap-1">
                <span class="text-2xl font-bold font-mono tabular-nums tracking-tight @if($summary['status'] === 'low') text-rose-600 dark:text-rose-400 @elseif($summary['status'] === 'high') text-amber-600 dark:text-amber-400 @else text-emerald-600 dark:text-emerald-400 @endif">
                    {{ $summary['total_hours'] }}
                </span>
                <span class="text-xs text-gray-400 dark:text-gray-500">hours</span>
            </div>
            @if($summary['total_seconds'] > 0)
            <div class="mt-2 w-full h-1.5 rounded-full bg-gray-100 dark:bg-gray-800 overflow-hidden">
                <div @class([
                    'h-full rounded-full transition-all duration-500',
                    'bg-rose-400' => $summary['status'] === 'low',
                    'bg-emerald-400' => $summary['status'] === 'ok',
                    'bg-amber-400' => $summary['status'] === 'high',
                ]) style="width: {{ min(100, ($summary['total_seconds'] / 28800) * 100) }}%"></div>
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

    {{-- Filter Bar --}}
    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 p-4">
        <div class="flex flex-wrap items-center gap-4">
            @php $user = auth()->user() @endphp
            @if ($user->isAdmin() && \App\Models\Team::where('leader_id', $user->id)->where('leader_status', 'accepted')->exists())
            <div class="flex items-center gap-2">
                <x-filament::input.wrapper>
                    <x-filament::input.checkbox wire:model.live="showAllUsers" label="Show all users (all teams)" />
                </x-filament::input.wrapper>
            </div>
            @endif
            <div class="w-72">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="selectedTeamId">
                        <option value="">All Teams</option>
                        @foreach ($this->getTeams() as $team)
                        <option value="{{ $team->id }}">{{ $team->name }} @if($team->leader) ({{ $team->leader->name }}) @endif</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div class="w-72">
                <x-filament::input.wrapper>
                    <x-filament::input.select wire:model.live="selectedUserId">
                        <option value="">All Members</option>
                        @foreach ($this->getUsers() as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </x-filament::input.select>
                </x-filament::input.wrapper>
            </div>

            <div class="w-72">
                <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
                    <x-filament::input
                        type="text"
                        wire:model.live.debounce.500ms="search"
                        placeholder="Search activity, project, or member..."
                    />
                </x-filament::input.wrapper>
            </div>
        </div>
    </div>

    {{-- Table --}}
    @php
        $entries = $this->getEntries();
        $teamMap = $this->getTeamMap();
    @endphp
    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">
        <table class="w-full text-sm">
            <thead>
            <tr class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-200 dark:border-white/10">
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Employee Name</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Team</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Activity</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400">Project</th>
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 cursor-pointer select-none" wire:click="sortBy('start_time')">
                    <div class="flex items-center gap-1">
                        <span>Start Time</span>
                        @if($sortColumn === 'start_time')
                        <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </div>
                </th>
                <th class="px-4 py-3 text-left font-medium text-gray-500 dark:text-gray-400 cursor-pointer select-none" wire:click="sortBy('end_time')">
                    <div class="flex items-center gap-1">
                        <span>End Time</span>
                        @if($sortColumn === 'end_time')
                        <span>{{ $sortDirection === 'asc' ? '▲' : '▼' }}</span>
                        @endif
                    </div>
                </th>
                <th class="px-4 py-3 text-right font-medium text-gray-500 dark:text-gray-400">Duration</th>
                <th class="px-4 py-3 text-center font-medium text-xs uppercase tracking-wider text-gray-500">Billable</th>
                <th class="px-4 py-3 text-center font-medium text-xs uppercase tracking-wider text-gray-500">Overtime</th>
            </tr>
            </thead>
            <tbody>
            @forelse ($entries as $entry)
            <tr wire:key="entry-{{ $entry->id }}" class="border-b border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5 transition duration-75">
                <td class="px-4 py-3">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-xs font-medium text-gray-600 dark:text-gray-300">
                            {{ strtoupper(substr($entry->user->name ?? 'US', 0, 2)) }}
                        </div>
                        <span class="font-medium text-gray-700 dark:text-gray-200">{{ $entry->user->name ?? 'Unknown' }}</span>
                    </div>
                </td>
                <td class="px-4 py-3">
                    @php
                        $userTeams = $teamMap->get($entry->user_id, collect());
                    @endphp
                    @if ($userTeams->isNotEmpty())
                    <div class="flex flex-wrap gap-1">
                        @foreach ($userTeams as $ut)
                        <span class="inline-flex items-center rounded-md bg-blue-50 dark:bg-blue-500/10 px-1.5 py-0.5 text-[11px] font-medium text-blue-700 dark:text-blue-300 ring-1 ring-inset ring-blue-500/20">
                            {{ $ut->team_name }}
                        </span>
                        @endforeach
                    </div>
                    @else
                    <span class="text-gray-400 dark:text-gray-500 text-xs">&mdash;</span>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-700 dark:text-gray-200">
                    <div>{{ $entry->description ?: '(no description)' }}</div>
                    @if(!empty($entry->tags))
                    <div class="flex flex-wrap gap-1 mt-1">
                        @foreach($entry->tags as $tag)
                        <span class="inline-flex items-center rounded-md bg-gray-100 px-1.5 py-0.5 text-xs font-medium text-gray-600 dark:bg-gray-800 dark:text-gray-400 ring-1 ring-inset ring-gray-500/10">
                            {{ $tag }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </td>
                <td class="px-4 py-3 text-gray-500 dark:text-gray-400">
                    {{ $entry->project?->name ?? '-' }}
                </td>
                <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                    {{ $entry->start_time ? $entry->start_time->format('d M Y H:i') : '--' }}
                </td>
                <td class="px-4 py-3 font-mono text-xs text-gray-600 dark:text-gray-400 whitespace-nowrap">
                    @if($entry->end_time)
                    {{ $entry->end_time->format('d M Y H:i') }}
                    @else
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10 dark:bg-emerald-500/10 dark:text-emerald-400 dark:ring-emerald-500/20">
                        Running
                    </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-right font-mono font-semibold text-gray-800 dark:text-gray-200 tabular-nums">
                    {{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}
                </td>
                <td class="px-4 py-3 text-center">
                    @if($entry->is_billable)
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-50/60 dark:bg-emerald-500/10 mx-auto" title="Billable">
                        <x-filament::icon icon="heroicon-m-check" class="w-3.5 h-3.5 text-emerald-500" />
                    </span>
                    @else
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-rose-50/40 dark:bg-rose-500/5 mx-auto" title="Not billable">
                        <x-filament::icon icon="heroicon-m-x-mark" class="w-3.5 h-3.5 text-rose-400" />
                    </span>
                    @endif
                </td>
                <td class="px-4 py-3 text-center">
                    @if($entry->is_overtime)
                    <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-amber-50/60 dark:bg-amber-500/10 mx-auto" title="Overtime">
                        <x-filament::icon icon="heroicon-o-clock" class="w-3.5 h-3.5 text-amber-500" />
                    </span>
                    @else
                    <span class="inline-flex items-center justify-center w-6 h-6 mx-auto text-gray-300 dark:text-gray-700" title="Regular">
                        &mdash;
                    </span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="px-4 py-8 text-center text-gray-400 dark:text-gray-500">
                    No time entries found for the selected filters.
                </td>
            </tr>
            @endforelse
            </tbody>
        </table>

        <div class="border-t border-gray-200/60 dark:border-white/5">
            <x-filament::pagination
                :paginator="$entries"
                :page-options="[5, 10, 25, 50]"
                current-page-option-property="perPage"
            />
        </div>
    </div>
</x-filament-panels::page>
