<x-filament-panels::page>
    <div class="fi-hr-recruitments">
        @include('filament.admin.components.recruitment-applications-sidebar', [
            'recruitmentApplicationsActive' => $recruitmentApplicationsActive,
        ])

        <div class="fi-hr-recruitments__content">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>