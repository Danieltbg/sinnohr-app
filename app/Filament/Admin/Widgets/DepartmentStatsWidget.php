<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

/**
 * KPI department ditampilkan di {@see EmployeeStatsWidget}.
 * Class ini memenuhi konvensi penamaan dashboard rules.
 */
class DepartmentStatsWidget extends EmployeeStatsWidget
{
    protected static bool $isDiscovered = false;
}
