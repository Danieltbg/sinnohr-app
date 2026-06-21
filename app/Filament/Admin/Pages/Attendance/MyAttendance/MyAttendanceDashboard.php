<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Attendance\MyAttendance;

use App\Filament\Admin\Concerns\InteractsWithAttendanceSidebar;
use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Carbon\Carbon;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class MyAttendanceDashboard extends Page
{
    use InteractsWithAttendanceSidebar;
    use RegistersAdminNavigation;

    protected static ?string $slug = 'attendance/my-attendance/dashboard';

    protected static bool $shouldRegisterNavigation = false;

    protected string $view = 'filament.admin.pages.attendance.my-attendance.dashboard';

    public int $calendarYear;

    public int $calendarMonth;

    public string $calendarView = 'month';

    public ?string $selectedDate = null;

    public static function attendanceMenuKey(): string
    {
        return 'dashboard';
    }

    public function mount(): void
    {
        $this->calendarYear = (int) now()->format('Y');
        $this->calendarMonth = (int) now()->format('n');
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function previousPeriod(): void
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->subMonth();
        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
    }

    public function nextPeriod(): void
    {
        $date = Carbon::create($this->calendarYear, $this->calendarMonth, 1)->addMonth();
        $this->calendarYear = $date->year;
        $this->calendarMonth = $date->month;
    }

    public function goToToday(): void
    {
        $this->calendarYear = (int) now()->format('Y');
        $this->calendarMonth = (int) now()->format('n');
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function setCalendarView(string $view): void
    {
        if (in_array($view, ['month', 'week', 'list'], true)) {
            $this->calendarView = $view;
        }
    }

    public function selectDate(string $date): void
    {
        $this->selectedDate = $date;

        $parsed = Carbon::parse($date);
        $this->calendarYear = $parsed->year;
        $this->calendarMonth = $parsed->month;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getAttendanceSidebarViewData(), [
            'analysisCards' => $this->analysisCards(),
            'summaryCards' => $this->summaryCards(),
            'calendar' => $this->buildCalendar(),
        ]);
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.attendance.my_attendance.dashboard.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.attendance.my_attendance.dashboard.breadcrumb');
    }

    /**
     * @return list<array{title: string, value: string, footer?: string, footer_muted?: bool}>
     */
    private function analysisCards(): array
    {
        $validUntil = now()->endOfYear()->format('Y-m-d');

        return [
            [
                'title' => __('filament.attendance.my_attendance.cards.present_days'),
                'value' => '16.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.late_arrivals'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.absences'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.overtime_hours'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.remote_work'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.attendance_requests'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.attendance_requests_footer'),
                'footer_muted' => true,
            ],
        ];
    }

    /**
     * @return list<array{title: string, value: string, footer?: string}>
     */
    private function summaryCards(): array
    {
        $validUntil = now()->endOfYear()->format('Y-m-d');

        return [
            [
                'title' => __('filament.attendance.my_attendance.cards.extra_hours'),
                'value' => '0.0',
                'footer' => __('filament.attendance.my_attendance.cards.valid_until', ['date' => $validUntil]),
            ],
            [
                'title' => __('filament.attendance.my_attendance.cards.pending_requests'),
                'value' => '1',
                'footer' => __('filament.attendance.my_attendance.cards.time_off_requests'),
            ],
        ];
    }

    /**
     * @return array{title: string, view: string, weekdays: list<string>, weeks: list<list<array{date: string, day: int, in_month: bool, is_today: bool, is_weekend: bool, is_selected: bool}>>}
     */
    private function buildCalendar(): array
    {
        $firstOfMonth = Carbon::create($this->calendarYear, $this->calendarMonth, 1);
        $start = $firstOfMonth->copy()->startOfWeek(Carbon::MONDAY);
        $end = $firstOfMonth->copy()->endOfMonth()->endOfWeek(Carbon::MONDAY);

        $weeks = [];
        $current = $start->copy();

        while ($current <= $end) {
            $week = [];

            for ($dayIndex = 0; $dayIndex < 7; $dayIndex++) {
                $dateString = $current->format('Y-m-d');

                $week[] = [
                    'date' => $dateString,
                    'day' => $current->day,
                    'in_month' => $current->month === $this->calendarMonth,
                    'is_today' => $current->isToday(),
                    'is_weekend' => $dayIndex >= 5,
                    'is_selected' => $this->selectedDate === $dateString,
                ];

                $current->addDay();
            }

            $weeks[] = $week;
        }

        return [
            'title' => $firstOfMonth->translatedFormat('F Y'),
            'view' => $this->calendarView,
            'weekdays' => [
                __('filament.attendance.my_attendance.calendar.weekdays.mon'),
                __('filament.attendance.my_attendance.calendar.weekdays.tue'),
                __('filament.attendance.my_attendance.calendar.weekdays.wed'),
                __('filament.attendance.my_attendance.calendar.weekdays.thu'),
                __('filament.attendance.my_attendance.calendar.weekdays.fri'),
                __('filament.attendance.my_attendance.calendar.weekdays.sat'),
                __('filament.attendance.my_attendance.calendar.weekdays.sun'),
            ],
            'weeks' => $weeks,
        ];
    }
}
