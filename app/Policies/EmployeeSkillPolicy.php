<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\EmployeeSkill;
use App\Models\User;

class EmployeeSkillPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, EmployeeSkill $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, EmployeeSkill $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, EmployeeSkill $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, EmployeeSkill $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, EmployeeSkill $model): bool
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
