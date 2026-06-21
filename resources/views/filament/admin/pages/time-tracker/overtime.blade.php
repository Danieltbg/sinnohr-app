<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Summary Card --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ __('Total Overtime Tracked') }}
                    </p>
                    <p class="text-3xl font-mono font-bold text-gray-800 dark:text-gray-200 mt-1 tabular-nums">
                        {{ $this->formatDuration($this->getTotalOvertimeSeconds()) }}
                    </p>
                </div>
                <div class="w-12 h-12 rounded-full bg-amber-50 dark:bg-amber-500/10 flex items-center justify-center">
                    <x-filament::icon icon="heroicon-o-clock" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>

        {{-- Entries Table --}}
        <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-white/10">
                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                    {{ __('Overtime Entries') }}
                </h3>
            </div>

            @php
                $entries = $this->getOvertimeEntries();
            @endphp

            @if ($entries->isEmpty())
                <div class="flex items-center justify-center px-4 py-12 text-sm text-gray-400 dark:text-gray-500">
                    {{ __('No overtime entries yet.') }}
                </div>
            @else
                <div class="divide-y divide-gray-100 dark:divide-white/5">
                    @foreach ($entries as $entry)
                        <div class="flex items-center justify-between px-4 py-3 hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                            <div class="flex items-center gap-3 min-w-0 flex-1">
                                <x-filament::icon icon="heroicon-o-clock" class="w-4 h-4 text-amber-500 flex-shrink-0" />
                                <div class="min-w-0">
                                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                                        {{ $entry->description ?: 'No description' }}
                                    </p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500">
                                        {{ $entry->date?->format('D, M j, Y') }}
                                        &middot;
                                        {{ $entry->start_time?->format('H:i') }} – {{ $entry->end_time?->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-4 flex-shrink-0">
                                @if ($entry->project?->name)
                                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $entry->project->name }}</span>
                                @endif
                                <span class="font-mono text-sm font-semibold text-gray-700 dark:text-gray-300 tabular-nums">
                                    {{ \App\Livewire\LiveTimeTracker::formatDuration($entry->duration) }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Back to Timesheet --}}
        <div class="text-center">
            <x-filament::button
                color="gray"
                tag="a"
                href="{{ route('filament.admin.pages.time-tracker.timesheet') }}"
            >
                {{ __('Back to Timesheet') }}
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
