<?php

declare(strict_types=1);

use App\Providers\Filament\AdminPanelProvider;
use App\Providers\Filament\AppServiceProvider;
use App\Providers\Filament\CustomerPanelProvider;
use Modules\Dashboard\DashboardServiceProvider;
use Modules\Identity\IdentityServiceProvider;

return [
    AppServiceProvider::class,
    DashboardServiceProvider::class,
    IdentityServiceProvider::class,
    AdminPanelProvider::class,
    CustomerPanelProvider::class,
];
