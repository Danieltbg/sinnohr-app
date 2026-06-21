<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (! $request->user() instanceof User) {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak.');
        }

        /** @var User $user */
        $user = $request->user();
        $current = $user->role instanceof RoleEnum ? $user->role->value : (string) $user->role;

        if ($current !== $role) {
            abort(Response::HTTP_FORBIDDEN, 'Akses ditolak.');
        }

        return $next($request);
    }
}
