<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('filament.time_tracker.reports.top_activities') }}
        </x-slot>

        <div class="divide-y divide-gray-100">
            @forelse ($activities as $activity)
                <div class="flex items-center gap-3 py-2.5 first:pt-0 last:pb-0">
                    {{-- Colored dot --}}
                    <span class="flex-shrink-0 w-2 h-2 rounded-full bg-blue-500"></span>

                    {{-- Activity info --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-700 truncate">
                            {{ $activity['description'] }}
                        </p>
                        @if ($activity['project'])
                            <p class="text-xs text-gray-500 truncate">
                                {{ $activity['project'] }}
                            </p>
                        @endif
                    </div>

                    {{-- Duration --}}
                    <span class="text-sm font-mono font-semibold text-gray-800 tabular-nums whitespace-nowrap">
                        {{ \App\Filament\Admin\Widgets\TopActivitiesWidget::formatDuration($activity['duration']) }}
                    </span>
                </div>
            @empty
                <p class="py-4 text-sm text-center text-gray-400">
                    {{ __('filament.time_tracker.reports.no_activities') }}
                </p>
            @endforelse
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
