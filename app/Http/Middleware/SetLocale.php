<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $this->resolveLocale($request);

        if ($locale !== null && $this->isSupportedLocale($locale)) {
            App::setLocale($locale);

            if ($request->hasSession()) {
                $request->session()->put('locale', $locale);
            }
        }

        return $next($request);
    }

    private function resolveLocale(Request $request): ?string
    {
        $queryLocale = $request->query('lang');

        if (is_string($queryLocale) && $queryLocale !== '') {
            return $queryLocale;
        }

        $user = $request->user();

        if ($user !== null && property_exists($user, 'language') && filled($user->language)) {
            return (string) $user->language;
        }

        if ($request->hasSession()) {
            $sessionLocale = $request->session()->get('locale');

            if (is_string($sessionLocale) && $sessionLocale !== '') {
                return $sessionLocale;
            }
        }

        return null;
    }

    private function isSupportedLocale(string $locale): bool
    {
        /** @var array<string, mixed> $supportedLocales */
        $supportedLocales = config('app.supported_locales', []);

        return array_key_exists($locale, $supportedLocales);
    }
}
