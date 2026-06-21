<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\ActivityPlan;
use App\Models\User;

class ActivityPlanPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, ActivityPlan $model): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, ActivityPlan $model): bool
    {
        return $user->isAdmin();
    }

    public function delete(User $user, ActivityPlan $model): bool
    {
        return $user->isAdmin();
    }

    public function restore(User $user, ActivityPlan $model): bool
    {
        return $user->isAdmin();
    }

    public function forceDelete(User $user, ActivityPlan $model): bool
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
