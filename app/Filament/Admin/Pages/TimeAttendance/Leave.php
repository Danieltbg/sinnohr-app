<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeAttendance;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Pages\BaseAdminPage;
use Filament\Support\Icons\Heroicon;

class Leave extends BaseAdminPage
{
    protected static ?string $title = 'Leave';

    protected static ?string $navigationLabel = 'Leave';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TIME_ATTENDANCE;

    protected static ?int $navigationSort = 50;
}
