<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\TimeAttendance;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Pages\BaseAdminPage;
use Filament\Support\Icons\Heroicon;

class TeamMeeting extends BaseAdminPage
{
    protected static ?string $title = 'Team Meeting';

    protected static ?string $navigationLabel = 'Team Meeting';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedCalendar;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_TIME_ATTENDANCE;

    protected static ?int $navigationSort = 40;
}
