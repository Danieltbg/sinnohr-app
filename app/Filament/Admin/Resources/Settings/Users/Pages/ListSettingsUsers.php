<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Users\Pages;

use App\Filament\Admin\Resources\Settings\Users\SettingsUserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListSettingsUsers extends ListRecords
{
    protected static string $resource = SettingsUserResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.settings.users.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.users.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            SettingsUserResource::getUrl('index') => __('filament.settings.users.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.settings.users.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
