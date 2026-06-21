<x-filament-panels::page>
    <div class="fi-hr-attendance">
        @include('filament.admin.components.attendance-sidebar', [
            'attendanceSidebarActive' => $attendanceSidebarActive,
        ])

        <div class="fi-hr-attendance__content">
            <x-filament::section>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $placeholderText }}
                </p>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
