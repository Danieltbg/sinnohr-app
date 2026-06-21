<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages\Settings;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Resources\Settings\Roles\RoleResource;
use Filament\Pages\Page;

class SettingsHub extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'settings';

    protected static bool $shouldRegisterNavigation = false;

    public function mount(): void
    {
        $this->redirect(RoleResource::getUrl('index'), navigate: true);
    }
}
