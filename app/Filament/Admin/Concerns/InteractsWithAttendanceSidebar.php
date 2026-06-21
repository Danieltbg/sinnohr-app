<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

trait InteractsWithAttendanceSidebar
{
    abstract public static function attendanceMenuKey(): string;

    /**
     * @return array<string, mixed>
     */
    protected function getAttendanceSidebarViewData(): array
    {
        return [
            'attendanceSidebarActive' => static::attendanceMenuKey(),
        ];
    }
}
