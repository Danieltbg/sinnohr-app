<div
    x-data="{
        seconds: @js($startedAt) ? Math.floor((Date.now() - new Date(@js($startedAt)).getTime()) / 1000) : 0,
        timerInterval: null,

        init() {
            if (@js($startedAt)) {
                this.startInterval();
            }
        },

        startInterval() {
            this.timerInterval = setInterval(() => { this.seconds++ }, 1000);
        },

        stopInterval() {
            if (this.timerInterval) {
                clearInterval(this.timerInterval);
                this.timerInterval = null;
            }
        },

        handleTimerStarted(startedAt) {
            this.stopInterval();
            this.seconds = Math.floor((Date.now() - new Date(startedAt).getTime()) / 1000);
            this.startInterval();
        },

        handleTimerStopped() {
            this.stopInterval();
            this.seconds = 0;
        },

        handleTimerContinued() {
            this.startInterval();
        },

        formatTime(seconds) {
            const hrs = String(Math.floor(seconds / 3600)).padStart(2, '0');
            const mins = String(Math.floor((seconds % 3600) / 60)).padStart(2, '0');
            const secs = String(seconds % 60).padStart(2, '0');
            return `${hrs}:${mins}:${secs}`;
        },
    }"
    x-on:timer-started.window="handleTimerStarted($event.detail.startedAt)"
    x-on:timer-stopped.window="handleTimerStopped()"
    x-on:timer-continue.window="handleTimerContinued()"
>
    {{-- Timer Bar --}}
    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4 p-4">

            <div class="flex-1 w-full md:w-auto min-w-0">
                <x-filament::input.wrapper
                    :valid="! $errors->has('taskDescription') && filled($taskDescription)"
                    :invalid="$errors->has('taskDescription')"
                    class="border-0 shadow-none bg-transparent"
                >
                    <x-filament::input
                        type="text"
                        wire:model="taskDescription"
                        placeholder="What are you working on?"
                        class="border-none focus:ring-0 bg-transparent px-0"
                    />
                </x-filament::input.wrapper>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto">
                <div class="flex items-center gap-4 border-r border-gray-200 dark:border-white/10 pr-4">

                    {{-- Project Dropdown --}}
                    <div class="relative" x-data="{ projectOpen: false }">
                        <x-filament::button
                            color="gray"
                            size="sm"
                            icon="heroicon-m-plus"
                            x-on:click="projectOpen = !projectOpen"
                            :outlined="! $selectedProject"
                        >
                            {{ $selectedProject ?: 'Project' }}
                        </x-filament::button>

                        <div
                            x-show="projectOpen"
                            x-on:click.outside="projectOpen = false"
                            x-cloak
                            class="absolute top-full left-0 z-50 mt-2 w-72 bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-xl shadow-lg"
                        >
                            <div class="p-2">
                                <x-filament::input.wrapper>
                                    <x-filament::input
                                        type="text"
                                        wire:model.live="projectSearch"
                                        placeholder="Search projects..."
                                    />
                                </x-filament::input.wrapper>
                            </div>

                            <div class="max-h-48 overflow-y-auto border-t border-gray-100 dark:border-white/10">
                                @forelse ($filteredProjects as $project)
                                <button
                                    type="button"
                                    wire:click="selectProject('{{ $project }}')"
                                    x-on:click="projectOpen = false"
                                    class="w-full px-3 py-2 text-sm text-left text-gray-700 dark:text-gray-300 transition-colors hover:bg-gray-50 dark:hover:bg-white/5"
                                >
                                    {{ $project }}
                                </button>
                                @empty
                                <p class="px-3 py-4 text-sm text-center text-gray-400">
                                    No projects found
                                </p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <x-filament::icon-button icon="heroicon-o-tag" color="gray" tooltip="Add tags" />

                    {{-- Billable Toggle --}}
                    <button
                        type="button"
                        wire:click="$toggle('isBillable')"
                        @class([
                    'flex items-center justify-center w-7 h-7 text-xs font-bold border rounded-md transition-colors',
                    'text-green-600 bg-green-50 border-green-300 dark:text-green-400 dark:bg-green-500/10 dark:border-green-500/30' => $isBillable,
                    'text-gray-400 border-gray-200 hover:border-gray-300 dark:text-gray-500 dark:border-white/10 dark:hover:border-white/20' => ! $isBillable,
                    ])
                    >
                    $
                    </button>

                    {{-- Overtime Toggle --}}
                    <button
                        type="button"
                        wire:click="$toggle('isOvertime')"
                        @class([
                    'flex items-center justify-center w-7 h-7 text-xs font-bold border rounded-md transition-colors',
                    'text-amber-600 bg-amber-50 border-amber-300 dark:text-amber-400 dark:bg-amber-500/10 dark:border-amber-500/30' => $isOvertime,
                    'text-gray-400 border-gray-200 hover:border-gray-300 dark:text-gray-500 dark:border-white/10 dark:hover:border-white/20' => ! $isOvertime,
                    ])
                    >
                    <x-filament::icon icon="heroicon-o-clock" class="w-3.5 h-3.5" />
                    </button>
                </div>

                <span
                    class="text-2xl font-mono font-semibold tracking-tight w-32 text-center text-gray-800 dark:text-white tabular-nums"
                    x-text="formatTime(seconds)"
                >
                    00:00:00
                </span>

                <x-filament::button
                    wire:click="{{ $isRunning ? 'stopTimer' : 'startTimer' }}"
                    x-on:click="if ($wire.isRunning) { stopInterval() }"
                    :color="$isRunning ? 'danger' : 'primary'"
                    tag="button"
                    :disabled="! $isRunning && ! $taskDescription"
                    class="min-w-[100px] justify-center"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove.delay="$isRunning ? 'stopTimer' : 'startTimer'" wire:target="{{ $isRunning ? 'stopTimer' : 'startTimer' }}">
                        {{ $isRunning ? 'STOP' : 'START' }}
                    </span>
                    <span wire:loading wire:target="{{ $isRunning ? 'stopTimer' : 'startTimer' }}" class="hidden">
                        ...
                    </span>
                </x-filament::button>
            </div>
        </div>
    </div>

    {{-- Worklog History: Desain Rapi Terstruktur --}}
    <div class="mt-8 bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden border border-gray-100 dark:border-white/5">
        @forelse ($groupedEntries ?? [] as $dateKey => $group)
        {{-- Date Group Header --}}
        <div class="bg-gray-50/70 dark:bg-gray-800/40 px-4 py-2.5 text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400 flex items-center justify-between border-b border-gray-100 dark:border-white/10">
            <span>{{ $group['label'] }}</span>
            <span class="font-mono tabular-nums text-sm text-gray-700 dark:text-gray-300">{{ $group['total_formatted'] }}</span>
        </div>

        {{-- List data baris row --}}
        <div class="divide-y divide-gray-100 dark:divide-white/5">
            @foreach ($group['entries'] as $entry)
            @include('livewire.partials.time-entry-row', ['entry' => $entry])
            @endforeach
        </div>
        @empty
        <div class="flex items-center justify-center px-4 py-12 text-sm text-gray-400 dark:text-gray-500">
            No time entries yet. Start tracking above.
        </div>
        @endforelse
    </div>
</div>
