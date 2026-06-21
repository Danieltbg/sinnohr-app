@php
    $tabs = $this->getTabs();
    $activeTab = $this->activeTab ?? 'summary';
@endphp

<x-filament-panels::page>
    <div class="mb-6">
        <x-filament::tabs>
            @foreach ($tabs as $tabKey => $tabLabel)
                <x-filament::tabs.item
                    :active="$activeTab === $tabKey"
                    wire:click="$set('activeTab', '{{ $tabKey }}')"
                >
                    {{ $tabLabel }}
                </x-filament::tabs.item>
            @endforeach
        </x-filament::tabs>
    </div>
</x-filament-panels::page>
