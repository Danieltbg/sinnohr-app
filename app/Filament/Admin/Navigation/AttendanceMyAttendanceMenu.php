<?php

declare(strict_types=1);

namespace App\Filament\Admin\Navigation;

use Filament\Support\Icons\Heroicon;

final class AttendanceMyAttendanceMenu
{
    /**
     * @return list<array{key: string, label: string, route: string, icon: Heroicon}>
     */
    public static function items(): array
    {
        return once(fn (): array => [
            self::item('dashboard', __('filament.attendance.my_attendance.menu.dashboard'), 'filament.admin.pages.attendance.my-attendance.dashboard', Heroicon::OutlinedSquares2x2),
            self::item('records', __('filament.attendance.my_attendance.menu.records'), 'filament.admin.pages.attendance.my-attendance.records', Heroicon::OutlinedGlobeAlt),
            self::item('allocation', __('filament.attendance.my_attendance.menu.allocation'), 'filament.admin.pages.attendance.my-attendance.allocation', Heroicon::OutlinedCalendarDays),
        ]);
    }

    /**
     * @return array{key: string, label: string, route: string, icon: Heroicon}
     */
    private static function item(string $key, string $label, string $route, Heroicon $icon): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'route' => $route,
            'icon' => $icon,
        ];
    }
}
