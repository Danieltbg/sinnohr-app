<?php

declare(strict_types=1);

namespace App\Http\Responses;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse as LoginResponseContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Features\SupportRedirects\Redirector;

class FilamentLoginResponse implements LoginResponseContract
{
    public function toResponse($request): RedirectResponse|Redirector
    {
        $user = auth()->user();

        $defaultUrl = match (true) {
            $user instanceof User && $user->isAdmin() => route('filament.admin.pages.dashboard'),
            $user instanceof User && $user->isUser() => route('filament.portal.pages.dashboard'),
            default => route('filament.portal.pages.dashboard'),
        };

        return redirect()->intended($defaultUrl);
    }
}
