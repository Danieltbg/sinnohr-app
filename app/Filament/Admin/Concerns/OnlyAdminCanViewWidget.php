<?php

declare(strict_types=1);

namespace App\Filament\Admin\Concerns;

use App\Models\User;

trait OnlyAdminCanViewWidget
{
    public static function canView(): bool
    {
        $user = auth()->user();

        return $user instanceof User && $user->isAdmin();
    }
}
