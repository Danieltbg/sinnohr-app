@php
    $checkIn = $check_in ?? '—';
    $checkOut = $check_out ?? '—';
    $status = $status ?? __('filament.widgets.attendance.not_checked_in');
@endphp

<x-filament-widgets::widget class="fi-hr-attendance-widget">
    <x-filament::section>
        <x-slot name="heading">
            {{ __('filament.widgets.attendance.heading') }}
        </x-slot>

        <div
            class="fi-hr-attendance-widget__body"
            wire:ignore
            x-data="{
                date: '',
                timeLabel: '',
                hourDeg: 0,
                minuteDeg: 0,
                secondDeg: 0,
                tick() {
                    const now = new Date();
                    const s = now.getSeconds();
                    const m = now.getMinutes();
                    const h = now.getHours() % 12;

                    this.secondDeg = s * 6;
                    this.minuteDeg = m * 6 + s * 0.1;
                    this.hourDeg = h * 30 + m * 0.5;
                    this.date = now.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric',
                    });
                    this.timeLabel = now.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                    });
                },
                init() {
                    this.tick();
                    setInterval(() => this.tick(), 1000);
                },
            }"
            x-init="init()"
        >
            <div class="fi-hr-attendance-widget__content">
            <p class="fi-hr-attendance-widget__date" x-text="date"></p>

            <div
                class="fi-hr-attendance-widget__clock"
                role="img"
                x-bind:aria-label="'Jam saat ini, ' + timeLabel"
            >
                <svg
                    class="fi-hr-attendance-widget__clock-svg"
                    viewBox="0 0 200 200"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                >
                    <defs>
                        <linearGradient id="fi-hr-clock-face" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#eff6ff" />
                            <stop offset="100%" style="stop-color:#dbeafe" />
                        </linearGradient>
                    </defs>

                    <circle cx="100" cy="100" r="96" fill="url(#fi-hr-clock-face)" stroke="#93c5fd" stroke-width="4" />
                    <circle cx="100" cy="100" r="82" fill="none" stroke="#bfdbfe" stroke-width="1" opacity="0.8" />

                    @foreach (range(0, 11) as $index)
                        @php
                            $angle = $index * 30;
                            $rad = deg2rad($angle - 90);
                            $outer = 88;
                            $inner = $index % 3 === 0 ? 76 : 80;
                            $x1 = 100 + $outer * cos($rad);
                            $y1 = 100 + $outer * sin($rad);
                            $x2 = 100 + $inner * cos($rad);
                            $y2 = 100 + $inner * sin($rad);
                            $strokeWidth = $index % 3 === 0 ? 3 : 1.5;
                        @endphp
                        <line
                            x1="{{ round($x1, 2) }}"
                            y1="{{ round($y1, 2) }}"
                            x2="{{ round($x2, 2) }}"
                            y2="{{ round($y2, 2) }}"
                            stroke="#2563eb"
                            stroke-width="{{ $strokeWidth }}"
                            stroke-linecap="round"
                        />
                    @endforeach

                    <g x-bind:transform="'rotate(' + hourDeg + ' 100 100)'">
                        <line x1="100" y1="100" x2="100" y2="62" stroke="#1f2937" stroke-width="5" stroke-linecap="round" />
                    </g>
                    <g x-bind:transform="'rotate(' + minuteDeg + ' 100 100)'">
                        <line x1="100" y1="100" x2="100" y2="48" stroke="#2563eb" stroke-width="3.5" stroke-linecap="round" />
                    </g>
                    <g x-bind:transform="'rotate(' + secondDeg + ' 100 100)'">
                        <line x1="100" y1="100" x2="100" y2="38" stroke="#f43f5e" stroke-width="1.5" stroke-linecap="round" />
                    </g>

                    <circle cx="100" cy="100" r="5" fill="#10b981" stroke="#fff" stroke-width="2" />
                </svg>
            </div>

            <p class="sr-only" x-text="timeLabel" aria-live="polite"></p>

            <div class="fi-hr-attendance-widget__meta">
                <div class="fi-hr-attendance-widget__row">
                    <span class="fi-hr-attendance-widget__label">{{ __('filament.widgets.attendance.status') }}</span>
                    <span class="fi-hr-attendance-widget__value">{{ $status }}</span>
                </div>
                <div class="fi-hr-attendance-widget__row">
                    <span class="fi-hr-attendance-widget__label">{{ __('filament.widgets.attendance.check_in') }}</span>
                    <span class="fi-hr-attendance-widget__value">{{ $checkIn }}</span>
                </div>
                <div class="fi-hr-attendance-widget__row">
                    <span class="fi-hr-attendance-widget__label">{{ __('filament.widgets.attendance.check_out') }}</span>
                    <span class="fi-hr-attendance-widget__value">{{ $checkOut ?: '—' }}</span>
                </div>
            </div>
            </div>

            <div class="fi-hr-attendance-widget__actions">
                <x-filament::button color="success" wire:click="checkIn">
                    {{ __('filament.widgets.attendance.check_in_action') }}
                </x-filament::button>
                <x-filament::button color="gray" outlined wire:click="checkOut">
                    {{ __('filament.widgets.attendance.check_out_action') }}
                </x-filament::button>
            </div>
        </div>
    </x-filament::section>

    <style>
        .fi-hr-attendance-widget__body {
            display: flex;
            flex: 1;
            flex-direction: column;
            min-height: 250px;
            padding: 0.25rem 0;
        }

        .fi-hr-attendance-widget__content {
            display: flex;
            flex: 1;
            flex-direction: column;
            align-items: center;
            gap: 0.625rem;
            width: 100%;
        }

        .fi-hr-attendance-widget__date {
            margin: 0;
            text-align: center;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgb(107 114 128);
        }

        .dark .fi-hr-attendance-widget__date {
            color: rgb(156 163 175);
        }

        .fi-hr-attendance-widget__clock {
            flex-shrink: 0;
            width: 9rem;
            height: 9rem;
        }

        .fi-hr-attendance-widget__clock-svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .dark .fi-hr-attendance-widget__clock-svg circle:first-of-type {
            fill: #1e3a8a;
            stroke: #3b82f6;
        }

        .dark .fi-hr-attendance-widget__clock-svg circle:nth-of-type(2) {
            stroke: #60a5fa;
        }

        .dark .fi-hr-attendance-widget__clock-svg line[stroke='#2563eb'] {
            stroke: #60a5fa;
        }

        .dark .fi-hr-attendance-widget__clock-svg g:nth-of-type(1) line {
            stroke: #e5e7eb;
        }

        .fi-hr-attendance-widget__meta {
            width: 100%;
            padding: 0.625rem 0.75rem;
            border-radius: 0.75rem;
            background: rgb(249 250 251);
            font-size: 0.8125rem;
        }

        .dark .fi-hr-attendance-widget__meta {
            background: rgba(255, 255, 255, 0.05);
        }

        .fi-hr-attendance-widget__row {
            display: flex;
            justify-content: space-between;
            gap: 0.5rem;
        }

        .fi-hr-attendance-widget__row + .fi-hr-attendance-widget__row {
            margin-top: 0.375rem;
        }

        .fi-hr-attendance-widget__label {
            color: rgb(107 114 128);
        }

        .dark .fi-hr-attendance-widget__label {
            color: rgb(156 163 175);
        }

        .fi-hr-attendance-widget__value {
            font-weight: 600;
            color: rgb(17 24 39);
        }

        .dark .fi-hr-attendance-widget__value {
            color: rgb(255 255 255);
        }

        .fi-hr-attendance-widget__actions {
            display: flex;
            width: 100%;
            flex-shrink: 0;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            margin-top: auto;
            padding-top: 0.75rem;
        }
    </style>
</x-filament-widgets::widget>
