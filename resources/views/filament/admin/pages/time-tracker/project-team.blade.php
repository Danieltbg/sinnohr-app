<x-filament-panels::page>
    <div class="bg-white dark:bg-gray-900 shadow-sm rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 overflow-hidden">
        @php
            $rows = $this->getProjectTeamData();
        @endphp

        @if (empty($rows))
            <div class="flex items-center justify-center px-4 py-12 text-sm text-gray-400 dark:text-gray-500">
                {{ __('No project data available.') }}
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50/70 dark:bg-gray-800/40 border-b border-gray-100 dark:border-white/10">
                            <th class="px-4 py-3 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">
                                {{ __('Project Name') }}
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">
                                {{ __('Client Name') }}
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">
                                {{ __('Assigned Team') }}
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">
                                {{ __('Leader') }}
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-semibold tracking-wider uppercase text-gray-500 dark:text-gray-400">
                                {{ __('Total Tracked') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-white/5">
                        @foreach ($rows as $row)
                            <tr class="hover:bg-gray-50/80 dark:hover:bg-white/[0.02] transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-gray-800 dark:text-gray-200">
                                    {{ $row->name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $row->client_name }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $row->team?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">
                                    {{ $row->team?->leader?->name ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-sm font-mono font-semibold text-gray-700 dark:text-gray-300 tabular-nums text-right">
                                    {{ \App\Filament\Admin\Pages\TimeTracker\ProjectTeam::formatDuration((int) $row->total_duration) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament-panels::page>
