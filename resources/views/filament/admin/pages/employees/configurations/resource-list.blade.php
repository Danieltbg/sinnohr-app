<x-filament-panels::page>
    <div class="fi-hr-configurations">
        @include('filament.admin.components.configurations-sidebar', [
            'configurationActive' => $configurationActive,
        ])

        <div class="fi-hr-configurations__content">
            {{ $this->table }}
        </div>
    </div>
</x-filament-panels::page>
