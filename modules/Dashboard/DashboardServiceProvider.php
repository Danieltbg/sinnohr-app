<?php

declare(strict_types=1);

namespace Modules\Dashboard;

use Illuminate\Support\ServiceProvider;
use Modules\Dashboard\Repositories\AdminDashboardStatsRepository;
use Modules\Dashboard\Services\AdminDashboardStatsService;

class DashboardServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AdminDashboardStatsRepository::class);
        $this->app->singleton(AdminDashboardStatsService::class);
    }
}
