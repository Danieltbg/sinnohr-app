@php
$projectName = $entry->project?->name ?? 'No Project';

$colors = match ($projectName) {
'Website Redesign' => ['bg' => 'bg-emerald-50 dark:bg-emerald-500/10', 'text' => 'text-emerald-700 dark:text-emerald-400', 'dot' => 'bg-emerald-500'],
'Marketing'        => ['bg' => 'bg-blue-50 dark:bg-blue-500/10',     'text' => 'text-blue-700 dark:text-blue-400',     'dot' => 'bg-blue-500'],
'Internal Tool'    => ['bg' => 'bg-violet-50 dark:bg-violet-500/10', 'text' => 'text-violet-700 dark:text-violet-400', 'dot' => 'bg-violet-500'],
'Mobile App'       => ['bg' => 'bg-pink-50 dark:bg-pink-500/10',     'text' => 'text-pink-700 dark:text-pink-400',     'dot' => 'bg-pink-500'],
'No Project'       => ['bg' => 'bg-gray-100 dark:bg-white/5',        'text' => 'text-gray-500 dark:text-gray-400',    'dot' => 'bg-gray-400'],
default            => ['bg' => 'bg-gray-100 dark:bg-white/5',        'text' => 'text-gray-600 dark:text-gray-400',    'dot' => 'bg-gray-400'],
};
@endphp

<div
    wire:key="entry-row-{{ $entry->id }}"
    x-data="{
        startTime: '{{ $entry->start_time?->format('H:i') ?? '' }}',
        endTime: '{{ $entry->end_time?->format('H:i') ?? '' }}',
        datePickerOpen: false,
        newDate: '{{ $entry->date?->format('Y-m-d') ?? '' }}',
        saveTimes() {
            if (this.startTime && this.endTime) {
                $wire.updateEntryTime('{{ $entry->id }}', this.startTime, this.endTime)
            }
        },
        saveDate() {
            if (this.newDate) {
                $wire.updateEntryDate('{{ $entry->id }}', this.newDate)
                this.datePickerOpen = false
            }
        }
    }"
    class="group flex items-center justify-between gap-4 px-4 py-3.5 hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors"
>
    {{-- SISI KIRI: Dot Bulat, Deskripsi Tugas, dan Badge Project --}}
    <div class="flex items-center gap-3 min-w-0 flex-1">
        <span class="w-2 h-2 rounded-full flex-shrink-0 {{ $colors['dot'] }}"></span>
        <div class="flex flex-col sm:flex-row sm:items-center gap-2 min-w-0">
            <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                {{ $entry->description ?: 'No description' }}
            </p>
            @if ($projectName)
            <span class="inline-flex items-center text-[11px] font-semibold px-2 py-0.5 rounded-full {{ $colors['bg'] }} {{ $colors['text'] }} w-max">
                    {{ $projectName }}
                </span>
            @endif
        </div>
    </div>

    {{-- SISI KANAN: $, Inline Times, Duration, Date Picker, Actions --}}
    <div class="flex items-center gap-3 flex-shrink-0">
        {{-- Billable Status --}}
        <span @class([
        'text-xs font-bold px-1.5 py-0.5 rounded flex-shrink-0',
        'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' => $entry->is_billable,
        'text-gray-300 dark:text-gray-600 border border-gray-200 dark:border-white/10' => !$entry->is_billable
        ])>$</span>

        {{-- Overtime Badge --}}
        @if ($entry->is_overtime)
        <span class="flex items-center justify-center w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0" title="Overtime">
            <x-filament::icon icon="heroicon-o-clock" class="w-3.5 h-3.5" />
        </span>
        @endif

        {{-- Editable Start Time --}}
        <input
            type="time"
            x-model="startTime"
            x-on:blur="saveTimes()"
            class="w-[4.5rem] text-xs font-mono text-gray-500 dark:text-gray-400 bg-transparent border border-transparent hover:border-gray-200 dark:hover:border-white/10 focus:border-gray-300 dark:focus:border-white/20 rounded px-1 py-0.5 outline-none transition-colors cursor-default"
        />

        <span class="text-xs text-gray-300 dark:text-gray-600 select-none">–</span>

        {{-- Editable End Time --}}
        <input
            type="time"
            x-model="endTime"
            x-on:blur="saveTimes()"
            class="w-[4.5rem] text-xs font-mono text-gray-500 dark:text-gray-400 bg-transparent border border-transparent hover:border-gray-200 dark:hover:border-white/10 focus:border-gray-300 dark:focus:border-white/20 rounded px-1 py-0.5 outline-none transition-colors cursor-default"
        />

        {{-- Total Duration --}}
        <span class="font-mono text-sm font-semibold text-gray-700 dark:text-gray-300 tabular-nums w-20 text-right">
            {{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}
        </span>

        {{-- Date Picker Icon + Popover --}}
        <div class="relative" x-data="{ dpOpen: false }">
            <x-filament::icon-button
                icon="heroicon-o-calendar-days"
                color="gray"
                size="sm"
                x-on:click="dpOpen = !dpOpen"
                tooltip="Change date"
            />
            <div
                x-show="dpOpen"
                x-on:click.outside="dpOpen = false"
                x-cloak
                class="absolute top-full right-0 z-50 mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-lg shadow-lg p-2"
            >
                <input
                    type="date"
                    x-model="newDate"
                    x-on:change="if (newDate) { $wire.updateEntryDate('{{ $entry->id }}', newDate); dpOpen = false }"
                    class="text-xs border border-gray-200 dark:border-white/10 rounded px-2 py-1 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 outline-none"
                />
            </div>
        </div>

        {{-- Tombol Play & Trash --}}
        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity w-14 justify-end">
            <x-filament::icon-button
                icon="heroicon-o-play"
                color="gray"
                size="sm"
                wire:click="restartEntry('{{ $entry->id }}')"
                tooltip="Restart this activity"
            />
            <x-filament::icon-button
                icon="heroicon-o-trash"
                color="danger"
                size="sm"
                wire:click="deleteEntry('{{ $entry->id }}')"
                wire:confirm="Delete this time entry?"
                tooltip="Delete"
            />
        </div>
    </div>
</div>
