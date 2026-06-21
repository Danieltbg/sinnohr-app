<?php

declare(strict_types=1);

namespace Modules\Identity\Services;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Identity\Repositories\UserRepository;

class ApiAuthService
{
    public function __construct(
        private readonly UserRepository $users,
    ) {}

    /**
     * @param  array{email: string, password: string, device_name?: string|null}  $credentials
     * @return array{token: string, token_type: string, user: User}
     */
    public function login(array $credentials): array
    {
        $user = $this->users->findByEmail($credentials['email']);

        if ($user === null || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => [__('auth.failed')],
            ]);
        }

        if (! $user->is_active) {
            throw new AuthorizationException('Account is inactive.');
        }

        $user->tokens()->delete();

        $tokenName = $credentials['device_name'] ?? 'api-token';
        $plainToken = $user->createToken($tokenName)->plainTextToken;

        $this->users->recordLogin($user);

        return [
            'token' => $plainToken,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }

    /**
     * @return array{token: string, token_type: string}
     */
    public function refreshToken(User $user): array
    {
        $user->tokens()->delete();
        $plainToken = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $plainToken,
            'token_type' => 'Bearer',
        ];
    }
}
