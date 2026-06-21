<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

use App\Models\User;

trait RegistersAdminNavigation
{
    public static function canAccess(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return static::canAccess();
    }
}
