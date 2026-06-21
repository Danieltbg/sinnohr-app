<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LoginRequest;
use App\Http\Resources\Api\V1\AuthTokenResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Identity\Services\ApiAuthService;

class AuthController extends Controller
{
    public function __construct(
        private readonly ApiAuthService $authService,
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        $payload = $this->authService->login($request->validated());

        return (new AuthTokenResource($payload))->response();
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();

        if (! $user instanceof User) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $payload = $this->authService->refreshToken($user);

        return (new AuthTokenResource($payload))->response();
    }
}
