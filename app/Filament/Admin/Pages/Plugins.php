<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Services\Admin\PluginRegistry;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Plugins extends Page
{
    use RegistersAdminNavigation;

    protected static ?string $slug = 'plugins';

    protected static ?string $navigationLabel = null;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedPuzzlePiece;

    protected static ?int $navigationSort = 100;

    protected string $view = 'filament.admin.pages.plugins';

    public static function getNavigationLabel(): string
    {
        return __('filament.plugins.navigation');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.plugins.title');
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return [
            'plugins' => app(PluginRegistry::class)->all(),
        ];
    }
}
