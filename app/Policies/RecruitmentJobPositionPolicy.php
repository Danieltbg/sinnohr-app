<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\RecruitmentJobPosition;
use App\Models\User;

class RecruitmentJobPositionPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, RecruitmentJobPosition $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, RecruitmentJobPosition $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, RecruitmentJobPosition $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, RecruitmentJobPosition $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, RecruitmentJobPosition $model): bool
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
