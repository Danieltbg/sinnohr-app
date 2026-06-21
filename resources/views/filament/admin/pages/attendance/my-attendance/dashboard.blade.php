<x-filament-panels::page>
    <div class="fi-hr-attendance">
        @include('filament.admin.components.attendance-sidebar', [
            'attendanceSidebarActive' => $attendanceSidebarActive,
        ])

        <div class="fi-hr-attendance__content">
            <h2 class="fi-hr-attendance__analysis-title">
                {{ __('filament.attendance.my_attendance.analysis_title') }}
            </h2>

            <div class="fi-hr-attendance__analysis-grid">
                @foreach ($analysisCards as $card)
                    <article class="fi-hr-attendance__analysis-card">
                        <h3 class="fi-hr-attendance__analysis-card-title">{{ $card['title'] }}</h3>
                        <p class="fi-hr-attendance__analysis-card-value">{{ $card['value'] }}</p>
                        @if (filled($card['footer'] ?? null))
                            <p @class([
                                'fi-hr-attendance__analysis-card-footer',
                                'fi-hr-attendance__analysis-card-footer--muted' => ($card['footer_muted'] ?? false),
                            ])>
                                {{ $card['footer'] }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>

            <div class="fi-hr-attendance__summary-grid">
                @foreach ($summaryCards as $card)
                    <article class="fi-hr-attendance__analysis-card">
                        <h3 class="fi-hr-attendance__analysis-card-title">{{ $card['title'] }}</h3>
                        <p class="fi-hr-attendance__analysis-card-value">{{ $card['value'] }}</p>
                        @if (filled($card['footer'] ?? null))
                            <p class="fi-hr-attendance__analysis-card-footer">
                                {{ $card['footer'] }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>

            @include('filament.admin.components.attendance-calendar', ['calendar' => $calendar])
        </div>
    </div>
</x-filament-panels::page>
