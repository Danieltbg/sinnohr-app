<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\EmployeeCompany;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Pages\BaseAdminPage;
use Filament\Support\Icons\Heroicon;

class Division extends BaseAdminPage
{
    protected static ?string $title = 'Divisi';

    protected static ?string $navigationLabel = 'Divisi';

    protected static ?string $navigationParentItem = AdminNavigation::PARENT_COMPANY_MANAGEMENT;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedSquares2x2;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_EMPLOYEE_COMPANY;

    protected static ?int $navigationSort = 12;
}
