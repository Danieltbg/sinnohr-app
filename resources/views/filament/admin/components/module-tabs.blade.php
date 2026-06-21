@php
    use App\Filament\Admin\Navigation\AdminAppLauncher;

    $tabs = AdminAppLauncher::contextualTabs();
    $moduleLabel = AdminAppLauncher::activeModuleLabel();
@endphp

<nav class="fi-hr-module-tabs" aria-label="{{ __('filament.navigation.module_tabs') }}">
    @if ($moduleLabel)
        <span class="fi-hr-module-tabs__module">{{ $moduleLabel }}</span>
    @endif

    @foreach ($tabs as $tab)
        <a
            href="{{ $tab['url'] }}"
            class="fi-hr-module-tabs__link {{ AdminAppLauncher::isTabActive($tab['url']) ? 'fi-hr-module-tabs__link--active' : '' }}"
        >
            {{ $tab['label'] }}
        </a>
    @endforeach
</nav>
