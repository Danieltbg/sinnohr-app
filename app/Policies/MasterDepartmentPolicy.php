<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\MasterDepartment;
use App\Models\User;

class MasterDepartmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, MasterDepartment $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, MasterDepartment $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, MasterDepartment $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, MasterDepartment $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, MasterDepartment $model): bool
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
