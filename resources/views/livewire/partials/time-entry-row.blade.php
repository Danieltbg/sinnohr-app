@php
$projectName = $entry->project?->name ?? 'No Project';

$projectColors = match ($projectName) {
'Website Redesign' => ['bg' => 'bg-teal-50 dark:bg-teal-500/10',   'text' => 'text-teal-700 dark:text-teal-400',   'dot' => 'bg-teal-500 dark:bg-teal-400'],
'Marketing'        => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',    'text' => 'text-blue-700 dark:text-blue-400',   'dot' => 'bg-blue-500 dark:bg-blue-400'],
'Internal Tool'    => ['bg' => 'bg-violet-50 dark:bg-violet-500/10','text' => 'text-violet-700 dark:text-violet-400','dot' => 'bg-violet-500 dark:bg-violet-400'],
'Mobile App'       => ['bg' => 'bg-pink-50 dark:bg-pink-500/10',    'text' => 'text-pink-700 dark:text-pink-400',   'dot' => 'bg-pink-500 dark:bg-pink-400'],
'No Project'       => ['bg' => 'bg-gray-100 dark:bg-white/5',       'text' => 'text-gray-400 dark:text-gray-500',   'dot' => 'bg-gray-300 dark:bg-gray-600'],
default            => ['bg' => 'bg-gray-100 dark:bg-white/5',       'text' => 'text-gray-500 dark:text-gray-400',   'dot' => 'bg-gray-400 dark:bg-gray-500'],
};

$approvalStatus = $entry->approval_status;
$isLocked = $entry->is_overtime && $approvalStatus === 'approved';
$isRejected = $entry->is_overtime && $approvalStatus === 'rejected';
@endphp

<div
    wire:key="entry-row-{{ $entry->id }}"
    x-data="{
        startTime: '{{ $entry->start_time?->format('H:i') ?? '' }}',
        endTime: '{{ $entry->end_time?->format('H:i') ?? '' }}',
        saveTimes() {
            if (this.startTime && this.endTime) {
                $wire.updateEntryTime('{{ $entry->id }}', this.startTime, this.endTime)
            }
        }
    }"
    class="group flex items-center gap-3.5 px-4 py-2.5
           bg-white dark:bg-gray-900
           border border-gray-100 dark:border-white/[0.06]
           rounded-xl
           hover:border-gray-200 dark:hover:border-white/10
           transition-colors duration-150
           mb-1.5"
>

    {{-- Dot --}}
    <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $projectColors['dot'] }}"></span>

    {{-- Col 1: Description + Tags --}}
    <div class="flex-1 min-w-0">
        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate leading-snug">
            {{ $entry->description ?: 'No description' }}
        </p>

        @if (!empty($entry->tags))
        <div class="mt-1 flex gap-1.5 flex-wrap">
            @foreach ($entry->tags as $tag)
            <span class="inline-flex items-center text-[11px] px-2 py-0.5 rounded-full
                                 bg-gray-100 dark:bg-white/5
                                 text-gray-500 dark:text-gray-400
                                 border border-gray-200 dark:border-white/10">
                        {{ $tag }}
                    </span>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Col 2: Project Badge --}}
    <div class="shrink-0">
        <span class="inline-flex items-center text-[11px] font-semibold px-2.5 py-1 rounded-full
                     {{ $projectColors['bg'] }} {{ $projectColors['text'] }} whitespace-nowrap">
            {{ $projectName }}
        </span>
    </div>

    {{-- Col 3: Billable --}}
    <span @class([
    'text-xs font-bold px-1.5 py-0.5 rounded flex-shrink-0',
    'bg-teal-50 text-teal-700 dark:bg-teal-500/10 dark:text-teal-400' => $entry->is_billable,
    'text-gray-300 dark:text-gray-600 border border-gray-200 dark:border-white/10' => !$entry->is_billable,
    ])>$</span>

    {{-- Col 4: Overtime Icon + Approval Status --}}
    @if ($entry->is_overtime)
    <span class="flex items-center justify-center w-5 h-5 text-amber-500 dark:text-amber-400 flex-shrink-0" title="Overtime">
            <x-filament::icon icon="heroicon-o-clock" class="w-3.5 h-3.5" />
        </span>
    <span @class([
        'inline-flex items-center text-[10px] font-semibold px-1.5 py-0.5 rounded-full flex-shrink-0',
        'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' => $approvalStatus === 'approved',
        'bg-amber-50 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' => $approvalStatus === 'pending',
        'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400' => $approvalStatus === 'rejected',
    ])>
        {{ ucfirst($approvalStatus) }}
    </span>
    @endif

    {{-- Col 5: Time Range --}}
    <div class="flex items-center gap-1.5 shrink-0">
        @if ($isLocked)
        <span class="font-mono text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
            {{ $entry->start_time?->format('H:i') ?? '--' }}
        </span>
        @else
        <input
            type="time"
            x-model="startTime"
            x-on:blur="saveTimes()"
            class="w-[5.5rem] h-9 text-sm font-mono text-gray-600 dark:text-gray-400
       bg-gray-50 dark:bg-white/5
       border border-gray-200 dark:border-white/10
       hover:border-gray-300 dark:hover:border-white/20
       focus:border-gray-400 dark:focus:border-white/30
       rounded-md px-2 py-1.5 outline-none transition-colors
       flex items-center"
        />
        @endif

        <span class="text-xs text-gray-300 dark:text-gray-600 select-none">–</span>

        @if ($entry->end_time)
            @if ($isLocked)
            <span class="font-mono text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                {{ $entry->end_time?->format('H:i') ?? '--' }}
            </span>
            @else
            <input
                type="time"
                x-model="endTime"
                x-on:blur="saveTimes()"
                class="w-[5.5rem] text-xs font-mono text-gray-600 dark:text-gray-400
                           bg-gray-50 dark:bg-white/5
                           border border-gray-200 dark:border-white/10
                           hover:border-gray-300 dark:hover:border-white/20
                           focus:border-gray-400 dark:focus:border-white/30
                           rounded-md px-1.5 py-1 outline-none transition-colors"
            />
            @endif
        @else
        {{-- Running Badge --}}
        <span class="relative inline-flex items-center gap-1.5 rounded-full
                         bg-teal-50 dark:bg-teal-500/10
                         px-2.5 py-1 text-[11px] font-medium
                         text-teal-700 dark:text-teal-400
                         ring-1 ring-inset ring-teal-500/20">
                <span class="relative flex w-2 h-2">
                    <span class="absolute inline-flex w-full h-full rounded-full bg-teal-400 opacity-75 animate-ping"></span>
                    <span class="relative inline-flex w-2 h-2 rounded-full bg-teal-500"></span>
                </span>
                Running
            </span>
        @endif
    </div>

    {{-- Col 6: Duration --}}
    <span class="font-mono text-sm font-semibold text-gray-800 dark:text-gray-200 tabular-nums w-16 text-right shrink-0">
        {{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}
    </span>

    {{-- Col 7: Actions (visible on hover) --}}
    <div class="flex items-center gap-0.5 shrink-0 opacity-0 group-hover:opacity-100 transition-opacity duration-150">

        @unless ($isLocked || $isRejected)
        {{-- Date Picker --}}
        <div class="relative" x-data="{ dpOpen: false }">
            <x-filament::icon-button
                icon="heroicon-o-calendar-days"
                color="gray"
                size="sm"
                x-on:click="dpOpen = !dpOpen"
                tooltip="Change date"
                class="rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 transition"
            />
            <div
                x-show="dpOpen"
                x-on:click.outside="dpOpen = false"
                x-cloak
                class="absolute top-full right-0 z-50 mt-1.5
                       bg-white dark:bg-gray-800
                       border border-gray-200 dark:border-white/10
                       rounded-xl shadow-lg p-2"
            >
                <input
                    type="date"
                    value="{{ $entry->date?->format('Y-m-d') ?? '' }}"
                    x-on:change="if ($event.target.value) { $wire.updateEntryDate('{{ $entry->id }}', $event.target.value); dpOpen = false }"
                    class="text-xs border border-gray-200 dark:border-white/10 rounded-lg
                           px-2 py-1.5
                           bg-white dark:bg-gray-800
                           text-gray-700 dark:text-gray-300 outline-none"
                />
            </div>
        </div>
        @endunless

        @unless ($isLocked)
        {{-- Delete --}}
        <x-filament::icon-button
            icon="heroicon-o-trash"
            color="danger"
            size="sm"
            wire:click="deleteEntry('{{ $entry->id }}')"
            wire:confirm="Delete this time entry?"
            tooltip="Delete"
            class="rounded-lg hover:bg-red-50 dark:hover:bg-red-500/10 transition"
        />
        @endunless
    </div>
</div>
