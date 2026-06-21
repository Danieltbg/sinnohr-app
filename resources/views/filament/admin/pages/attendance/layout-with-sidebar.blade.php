<x-filament-panels::page>
    <div class="fi-hr-attendance">
        @include('filament.admin.components.attendance-sidebar', [
            'attendanceSidebarActive' => $attendanceSidebarActive,
        ])

        <div class="fi-hr-attendance__content">
            {{ $slot ?? '' }}
            @isset($slot)
            @else
                {{ $this->getChildComponentContainer() }}
            @endisset
        </div>
    </div>
</x-filament-panels::page>
