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
    {{-- Rigid Single-Row Top Bar --}}
    <div class="flex flex-col sm:flex-row items-center gap-4 w-full bg-white dark:bg-gray-900 p-3 rounded-xl border border-gray-200 dark:border-white/5 shadow-sm">
        <div class="flex-1 min-w-0 w-full">
            <x-filament::input.wrapper
                :valid="! $errors->has('taskDescription') && filled($taskDescription)"
                :invalid="$errors->has('taskDescription')"
                class="border-0 shadow-none bg-transparent"
            >
                <x-filament::input
                    type="text"
                    wire:model="taskDescription"
                    placeholder="What are you working on?"
                    class="border-none focus:ring-0 bg-transparent px-0 text-sm placeholder:text-gray-400 dark:placeholder:text-gray-500"
                />
            </x-filament::input.wrapper>
        </div>

        <div class="flex items-center gap-3 shrink-0 w-full sm:w-auto">
            <div class="flex items-center gap-1.5 sm:gap-2 border-r border-gray-200 dark:border-white/10 pr-2 sm:pr-3">

                {{-- Project Dropdown --}}
                <div class="relative" x-data="{ projectOpen: false }">
                    <x-filament::icon-button
                        icon="heroicon-m-plus"
                        color="gray"
                        size="sm"
                        x-on:click="projectOpen = !projectOpen"
                        :tooltip="$selectedProject ?: 'Select project'"
                        class="rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 transition"
                    />
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
                                wire:key="project-{{ $loop->index }}"
                                wire:click="selectProject('{{ $project }}')"
                                x-on:click="projectOpen = false"
                                class="w-full px-3 py-2 text-sm text-left text-gray-700 dark:text-gray-300 transition-colors hover:bg-gray-50 dark:hover:bg-white/5"
                            >
                                {{ $project }}
                            </button>
                            @empty
                            <p class="px-3 py-4 text-sm text-center text-gray-400">No projects found</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Tags --}}
                <div class="relative" x-data="{ tagsOpen: false }">
                    <x-filament::icon-button
                        icon="heroicon-o-tag"
                        color="gray"
                        size="sm"
                        x-on:click="tagsOpen = !tagsOpen"
                        :tooltip="count($selectedTags) . ' tag(s) selected'"
                        class="rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 transition"
                    />
                    <div
                        x-show="tagsOpen"
                        x-on:click.outside="tagsOpen = false"
                        x-cloak
                        class="absolute top-full left-0 z-50 mt-2 w-64 bg-white dark:bg-gray-800 border border-gray-200 dark:border-white/10 rounded-xl shadow-lg"
                    >
                        <div class="p-1.5 space-y-0.5">
                            @foreach (\App\Livewire\LiveTimeTracker::TAGS as $tag)
                            <label
                                wire:key="tag-{{ $loop->index }}"
                                class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm cursor-pointer transition-colors hover:bg-gray-50 dark:hover:bg-white/5"
                            >
                                <x-filament::input.checkbox
                                    :value="in_array($tag, $selectedTags)"
                                    wire:click="toggleTag('{{ $tag }}')"
                                />
                                <span class="text-gray-700 dark:text-gray-300">{{ $tag }}</span>
                            </label>
                            @endforeach
                        </div>
                        @error('selectedTags')
                        <div class="px-3 pb-2 text-xs text-danger-600 dark:text-danger-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Billable --}}
                <button
                    type="button"
                    wire:click="$toggle('isBillable')"
                    @class([
                        'flex items-center justify-center w-7 h-7 text-xs font-bold border rounded-lg transition-colors',
                        'text-green-600 bg-green-50 border-green-300 dark:text-green-400 dark:bg-green-500/10 dark:border-green-500/30' => $isBillable,
                        'text-gray-400 border-gray-200 hover:border-gray-300 dark:text-gray-500 dark:border-white/10 dark:hover:border-white/20' => ! $isBillable,
                    ])
                    title="Billable"
                >
                    $
                </button>

                {{-- Overtime --}}
                <button
                    type="button"
                    wire:click="$toggle('isOvertime')"
                    @class([
                        'flex items-center justify-center w-7 h-7 text-xs font-bold border rounded-lg transition-colors',
                        'text-amber-600 bg-amber-50 border-amber-300 dark:text-amber-400 dark:bg-amber-500/10 dark:border-amber-500/30' => $isOvertime,
                        'text-gray-400 border-gray-200 hover:border-gray-300 dark:text-gray-500 dark:border-white/10 dark:hover:border-white/20' => ! $isOvertime,
                    ])
                    title="Overtime"
                >
                    <x-filament::icon icon="heroicon-o-clock" class="w-3.5 h-3.5" />
                </button>
            </div>

            {{-- Timer Display --}}
            <span
                class="text-2xl font-mono font-semibold tracking-tight w-28 text-center text-gray-800 dark:text-white tabular-nums select-none"
                x-text="formatTime(seconds)"
            >00:00:00</span>

            {{-- START / STOP --}}
            <x-filament::button
                wire:click="{{ $isRunning ? 'stopTimer' : 'startTimer' }}"
                x-on:click="if ($wire.isRunning) { stopInterval() }"
                :color="$isRunning ? 'danger' : 'primary'"
                tag="button"
                :disabled="! $isRunning && ! $taskDescription"
                class="min-w-[100px] justify-center rounded-xl shadow-sm"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove.delay="$isRunning ? 'stopTimer' : 'startTimer'" wire:target="{{ $isRunning ? 'stopTimer' : 'startTimer' }}">
                    {{ $isRunning ? 'STOP' : 'START' }}
                </span>
                <span wire:loading wire:target="{{ $isRunning ? 'stopTimer' : 'startTimer' }}" class="hidden">...</span>
            </x-filament::button>
        </div>
    </div>

    {{-- Structured Worklog History --}}
    <div class="mt-8 space-y-4">
        @forelse ($groupedEntries ?? [] as $dateKey => $group)
        <div wire:key="date-group-{{ $dateKey }}" class="border border-gray-100 dark:border-white/5 rounded-xl overflow-hidden bg-white dark:bg-gray-900 shadow-sm">
            {{-- Date Header --}}
            <div class="bg-gray-50/70 dark:bg-gray-800/40 px-4 py-2.5 flex items-center justify-between border-b border-gray-100 dark:border-white/5">
                <span class="font-medium text-gray-500 dark:text-gray-400 text-xs uppercase tracking-wider">{{ $group['label'] }}</span>
                <span class="font-mono tabular-nums text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $group['total_formatted'] }}</span>
            </div>

            {{-- Rows --}}
            <div class="divide-y divide-gray-50 dark:divide-white/[0.02]">
                @foreach ($group['entries'] as $entry)
                @include('livewire.partials.time-entry-row', ['entry' => $entry])
                @endforeach
            </div>
        </div>
        @empty
        <div class="flex items-center justify-center px-4 py-16 text-sm text-gray-400 dark:text-gray-500 border border-dashed border-gray-200 dark:border-white/10 rounded-xl">
            No time entries yet. Start tracking above.
        </div>
        @endforelse
    </div>
</div>
