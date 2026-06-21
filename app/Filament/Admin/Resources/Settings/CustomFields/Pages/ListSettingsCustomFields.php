<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\CustomFields\Pages;

use App\Filament\Admin\Resources\Settings\CustomFields\SettingsCustomFieldResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListSettingsCustomFields extends ListRecords
{
    protected static string $resource = SettingsCustomFieldResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.settings.custom_fields.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.custom_fields.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            SettingsCustomFieldResource::getUrl('index') => __('filament.settings.custom_fields.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.settings.custom_fields.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
