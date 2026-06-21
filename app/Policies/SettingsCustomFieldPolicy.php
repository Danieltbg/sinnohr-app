<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\SettingsCustomField;
use App\Models\User;

class SettingsCustomFieldPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, SettingsCustomField $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, SettingsCustomField $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, SettingsCustomField $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, SettingsCustomField $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, SettingsCustomField $model): bool
    {
        return $user->isAdmin();
    }

    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
