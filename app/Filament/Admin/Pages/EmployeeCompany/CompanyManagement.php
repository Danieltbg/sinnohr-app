<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\EmployeeCompany;

use App\Filament\Admin\Navigation\AdminNavigation;
use App\Filament\Admin\Pages\BaseAdminPage;
use Filament\Support\Icons\Heroicon;

class CompanyManagement extends BaseAdminPage
{
    protected static ?string $title = 'Company Management';

    protected static ?string $navigationLabel = 'Company Management';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|\UnitEnum|null $navigationGroup = AdminNavigation::GROUP_EMPLOYEE_COMPANY;

    protected static ?int $navigationSort = 10;
}
