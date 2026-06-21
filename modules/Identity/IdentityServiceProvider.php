<?php

declare(strict_types=1);

namespace Modules\Identity;

use Illuminate\Support\ServiceProvider;
use Modules\Identity\Repositories\UserRepository;
use Modules\Identity\Services\ApiAuthService;

class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(UserRepository::class);
        $this->app->singleton(ApiAuthService::class);
    }
}
