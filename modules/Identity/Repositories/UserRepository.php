<?php

declare(strict_types=1);

namespace Modules\Identity\Repositories;

use App\Models\User;

class UserRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function recordLogin(User $user): void
    {
        $user->userAuth()->updateOrCreate(
            ['user_id' => $user->id],
            ['last_login_at' => now()],
        );
    }
}
