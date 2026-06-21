@php
    use App\Filament\Admin\Navigation\EmployeeConfigurationMenu;

    $sections = EmployeeConfigurationMenu::sections();
@endphp

<aside class="fi-hr-configurations__sidebar" aria-label="{{ __('filament.employees.configurations.sidebar') }}">
    @foreach ($sections as $section)
        <div class="fi-hr-configurations__section">
            <p class="fi-hr-configurations__section-title">
                {{ $section['label'] }}
            </p>

            <nav class="fi-hr-configurations__section-nav">
                @foreach ($section['items'] as $item)
                    <a
                        href="{{ route($item['route']) }}"
                        @class([
                            'fi-hr-configurations__link',
                            'fi-hr-configurations__link--active' => ($configurationActive ?? '') === $item['key'],
                        ])
                    >
                        <x-filament::icon
                            :icon="$item['icon']"
                            class="fi-hr-configurations__link-icon"
                        />
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
        </div>
    @endforeach
</aside>
