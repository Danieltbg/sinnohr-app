<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies\Pages;

use App\Filament\Admin\Resources\Settings\Companies\SettingsCompanyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListSettingsCompanies extends ListRecords
{
    protected static string $resource = SettingsCompanyResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.settings.companies.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.companies.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            SettingsCompanyResource::getUrl('index') => __('filament.settings.companies.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.settings.companies.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
