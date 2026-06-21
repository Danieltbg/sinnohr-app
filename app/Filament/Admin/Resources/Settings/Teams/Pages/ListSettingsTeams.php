<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams\Pages;

use App\Filament\Admin\Resources\Settings\Teams\SettingsTeamResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListSettingsTeams extends ListRecords
{
    protected static string $resource = SettingsTeamResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.settings.teams.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.teams.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            SettingsTeamResource::getUrl('index') => __('filament.settings.teams.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.settings.teams.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
