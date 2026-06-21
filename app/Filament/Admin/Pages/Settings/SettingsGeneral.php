<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Settings;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class SettingsGeneral extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'settings/general';

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected string $view = 'filament.admin.pages.settings.general';

    public static function getNavigationLabel(): string
    {
        return __('filament.settings.general.navigation');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.settings.general.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.general.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            static::getUrl() => __('filament.settings.general.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }
}
