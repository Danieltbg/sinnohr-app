@php
    use App\Filament\Admin\Navigation\AdminAppLauncher;

    $items = AdminAppLauncher::items();
@endphp

<div
    class="fi-hr-app-launcher"
    x-data="{ open: false }"
    x-on:keydown.escape.window="open = false"
>
    <button
        type="button"
        class="fi-hr-app-launcher__trigger"
        x-on:click="open = ! open"
        :aria-expanded="open"
        aria-controls="fi-hr-app-launcher-panel"
        aria-label="{{ __('filament.navigation.open_app_launcher') }}"
    >
        <svg class="fi-hr-app-launcher__grid-icon" viewBox="0 0 24 24" aria-hidden="true">
            @foreach (range(0, 8) as $index)
                @php
                    $col = $index % 3;
                    $row = intdiv($index, 3);
                    $cx = 4 + ($col * 8);
                    $cy = 4 + ($row * 8);
                @endphp
                <circle cx="{{ $cx }}" cy="{{ $cy }}" r="2" fill="currentColor" />
            @endforeach
        </svg>
    </button>

    <div
        id="fi-hr-app-launcher-panel"
        class="fi-hr-app-launcher__panel"
        x-show="open"
        x-transition.opacity.duration.150ms
        x-on:click.outside="open = false"
        x-cloak
    >
        <div class="fi-hr-app-launcher__grid">
            @foreach ($items as $item)
                <a
                    href="{{ $item['url'] }}"
                    class="fi-hr-app-launcher__item {{ AdminAppLauncher::isActive($item['url']) ? 'fi-hr-app-launcher__item--active' : '' }}"
                    x-on:click="open = false"
                >
                    <span
                        class="fi-hr-app-launcher__icon"
                        style="--module-color: {{ $item['color'] }}; --module-accent: {{ $item['accent'] }};"
                    >
                        <x-filament::icon
                            :icon="$item['icon']"
                            class="fi-hr-app-launcher__icon-svg"
                        />
                    </span>
                    <span class="fi-hr-app-launcher__label">{{ $item['label'] }}</span>
                </a>
            @endforeach
        </div>
    </div>
</div>
