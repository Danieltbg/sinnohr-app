<x-filament-panels::page>
    <div
        class="fi-hr-plugins"
        x-data="{
            query: '',
            matches(name, description) {
                const q = this.query.trim().toLowerCase();
                if (q === '') return true;
                return name.toLowerCase().includes(q) || description.toLowerCase().includes(q);
            },
        }"
    >
        <div class="fi-hr-plugins__toolbar">
            <div class="fi-hr-plugins__search">
                <x-filament::icon
                    icon="heroicon-m-magnifying-glass"
                    class="fi-hr-plugins__search-icon"
                />
                <input
                    type="search"
                    class="fi-hr-plugins__search-input"
                    placeholder="{{ __('filament.plugins.search_placeholder') }}"
                    x-model="query"
                />
            </div>
            <p class="fi-hr-plugins__count">
                {{ __('filament.plugins.showing_count', ['count' => count($plugins)]) }}
            </p>
        </div>

        <div class="fi-hr-plugins__grid">
            @foreach ($plugins as $plugin)
                <article
                    class="fi-hr-plugins__card"
                    x-show="matches(@js($plugin['name']), @js($plugin['description']))"
                    x-transition.opacity
                >
                    <div class="fi-hr-plugins__card-header">
                        <span
                            class="fi-hr-plugins__card-icon"
                            style="--module-color: {{ $plugin['color'] }}; --module-accent: {{ $plugin['accent'] }};"
                        >
                            <x-filament::icon
                                :icon="$plugin['icon']"
                                class="fi-hr-plugins__card-icon-svg"
                            />
                        </span>

                        <div class="fi-hr-plugins__card-heading">
                            <h3 class="fi-hr-plugins__card-title">
                                @if ($plugin['url'])
                                    <a href="{{ $plugin['url'] }}" class="fi-hr-plugins__card-link">
                                        {{ $plugin['name'] }}
                                    </a>
                                @else
                                    {{ $plugin['name'] }}
                                @endif
                            </h3>
                            <span class="fi-hr-plugins__card-version">{{ $plugin['version'] }}</span>
                        </div>
                    </div>

                    <p class="fi-hr-plugins__card-description">
                        {{ $plugin['description'] }}
                    </p>

                    <div class="fi-hr-plugins__card-badges">
                        @if ($plugin['installed'])
                            <span class="fi-hr-plugins__badge fi-hr-plugins__badge--installed">
                                {{ __('filament.plugins.installed') }}
                            </span>
                        @else
                            <span class="fi-hr-plugins__badge fi-hr-plugins__badge--available">
                                {{ __('filament.plugins.available') }}
                            </span>
                        @endif

                        @if ($plugin['dependencies_count'] > 0)
                            <span class="fi-hr-plugins__badge fi-hr-plugins__badge--dependencies">
                                {{ trans_choice('filament.plugins.dependencies', $plugin['dependencies_count'], ['count' => $plugin['dependencies_count']]) }}
                            </span>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</x-filament-panels::page>
