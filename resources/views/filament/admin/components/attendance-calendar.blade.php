<section class="fi-hr-attendance__calendar" aria-label="{{ __('filament.attendance.my_attendance.calendar.title') }}">
    <header class="fi-hr-attendance__calendar-toolbar">
        <div class="fi-hr-attendance__calendar-nav">
            <div class="fi-hr-attendance__calendar-nav-group">
                <button
                    type="button"
                    class="fi-hr-attendance__calendar-nav-btn"
                    wire:click="previousPeriod"
                    aria-label="{{ __('filament.attendance.my_attendance.calendar.previous') }}"
                >
                    <x-filament::icon icon="heroicon-m-chevron-left" class="fi-hr-attendance__calendar-nav-icon" />
                </button>
                <button
                    type="button"
                    class="fi-hr-attendance__calendar-nav-btn"
                    wire:click="nextPeriod"
                    aria-label="{{ __('filament.attendance.my_attendance.calendar.next') }}"
                >
                    <x-filament::icon icon="heroicon-m-chevron-right" class="fi-hr-attendance__calendar-nav-icon" />
                </button>
            </div>

            <button
                type="button"
                class="fi-hr-attendance__calendar-today-btn"
                wire:click="goToToday"
            >
                {{ __('filament.attendance.my_attendance.calendar.today') }}
            </button>
        </div>

        <h2 class="fi-hr-attendance__calendar-title">{{ $calendar['title'] }}</h2>

        <div class="fi-hr-attendance__calendar-actions">
            <button
                type="button"
                class="fi-hr-attendance__calendar-icon-btn"
                title="{{ __('filament.attendance.my_attendance.calendar.settings') }}"
            >
                <x-filament::icon icon="heroicon-m-cog-6-tooth" class="fi-hr-attendance__calendar-action-icon" />
            </button>

            <button type="button" class="fi-hr-attendance__calendar-new-btn">
                <x-filament::icon icon="heroicon-m-plus" class="fi-hr-attendance__calendar-action-icon" />
                {{ __('filament.attendance.my_attendance.calendar.new_time_off') }}
            </button>

            <div class="fi-hr-attendance__calendar-view-toggle" role="group">
                @foreach (['month', 'week', 'list'] as $view)
                    <button
                        type="button"
                        @class([
                            'fi-hr-attendance__calendar-view-btn',
                            'fi-hr-attendance__calendar-view-btn--active' => $calendar['view'] === $view,
                        ])
                        wire:click="setCalendarView('{{ $view }}')"
                    >
                        {{ __('filament.attendance.my_attendance.calendar.views.'.$view) }}
                    </button>
                @endforeach
            </div>
        </div>
    </header>

    @if ($calendar['view'] === 'month')
        <div class="fi-hr-attendance__calendar-grid">
            <div class="fi-hr-attendance__calendar-weekdays">
                @foreach ($calendar['weekdays'] as $index => $weekday)
                    <div @class([
                        'fi-hr-attendance__calendar-weekday',
                        'fi-hr-attendance__calendar-weekday--weekend' => $index >= 5,
                    ])>
                        {{ $weekday }}
                    </div>
                @endforeach
            </div>

            @foreach ($calendar['weeks'] as $week)
                <div class="fi-hr-attendance__calendar-week">
                    @foreach ($week as $day)
                        <button
                            type="button"
                            @class([
                                'fi-hr-attendance__calendar-day',
                                'fi-hr-attendance__calendar-day--outside' => ! $day['in_month'],
                                'fi-hr-attendance__calendar-day--weekend' => $day['is_weekend'],
                                'fi-hr-attendance__calendar-day--today' => $day['is_today'],
                                'fi-hr-attendance__calendar-day--selected' => $day['is_selected'],
                            ])
                            wire:click="selectDate('{{ $day['date'] }}')"
                        >
                            {{ $day['day'] }}
                        </button>
                    @endforeach
                </div>
            @endforeach
        </div>
    @else
        <div class="fi-hr-attendance__calendar-placeholder">
            <p>{{ __('filament.attendance.my_attendance.calendar.view_placeholder', ['view' => __('filament.attendance.my_attendance.calendar.views.'.$calendar['view'])]) }}</p>
        </div>
    @endif
</section>
