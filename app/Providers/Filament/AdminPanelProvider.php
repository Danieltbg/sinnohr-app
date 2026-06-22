<?php

declare(strict_types=1);

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\CustomLogin;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\View\PanelsRenderHook;
use Illuminate\Contracts\View\View;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->authGuard('web')
            ->homeUrl(fn (): string => route('filament.admin.pages.dashboard'))
            ->login(CustomLogin::class)
            ->brandLogo(asset('images/logo-landscape.webp'))
            ->brandLogoHeight('2rem')
            ->colors([
                'primary' => Color::Blue,
            ])
            /* 👇 BARIS SAKTI: Menyuruh Filament menggunakan file CSS kustom kita 👇 */
            ->viteTheme('resources/css/filament/admin/theme.css')

            ->topNavigation()
            ->navigation(false)
            ->maxContentWidth(Width::Full)
            ->databaseNotifications()
            ->unsavedChangesAlerts()
            ->renderHook(
                PanelsRenderHook::TOPBAR_BEFORE,
                fn (): View => view('filament.admin.components.brand-bar'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_LOGO_BEFORE,
                fn (): View => view('filament.admin.components.app-launcher'),
            )
            ->renderHook(
                PanelsRenderHook::TOPBAR_LOGO_AFTER,
                fn (): View => view('filament.admin.components.module-tabs'),
            )
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn (): HtmlString => new HtmlString(
                    '<link rel="stylesheet" href="'.asset('css/filament/admin-layout.css').'" />'
                ),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): string => Blade::render('@livewire(\'team-invitation-handler\')'),
            )
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): HtmlString => new HtmlString(
                    <<<'HTML'
<script>
document.addEventListener('click', function(e) {
    const title = e.target.closest('.fi-no-notification-title');
    if (!title) return;
    const ctn = title.closest('.fi-no-notification-read-ctn');
    if (ctn) return;
    const el = title.closest('[x-data]');
    if (el && window.Alpine) {
        window.Alpine.$data(el)?.markAsRead?.();
    }
});

document.addEventListener('livewire:navigated', function() {
    Livewire.on('reload-page', function() {
        window.location.reload();
    });
});
</script>
HTML
                ),
            )
            ->navigationGroups([
                'Employee & Company',
                'Time Tracker',
                'Time & Attendance',
            ])
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\\Filament\\Admin\\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\\Filament\\Admin\\Pages')
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\\Filament\\Admin\\Widgets')
            ->discoverLivewireComponents(in: app_path('Livewire'), for: 'App\\Livewire')
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
