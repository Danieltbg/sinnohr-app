<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                    <span class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-400 dark:to-indigo-400 bg-clip-text text-transparent">Timesheet</span>
                </h1>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track your work time, manage projects, and stay productive.</p>
            </div>
            <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
                <span class="inline-flex items-center gap-1.5 rounded-full bg-gray-100 dark:bg-white/5 px-3 py-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    {{ now('Asia/Jakarta')->format('l, d M Y') }}
                </span>
            </div>
        </div>

        <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500/10 via-indigo-500/10 to-purple-500/10 rounded-2xl blur-xl"></div>
            <div class="relative bg-white dark:bg-gray-900 rounded-2xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <livewire:live-time-tracker />
            </div>
        </div>
    </div>
</x-filament-panels::page>