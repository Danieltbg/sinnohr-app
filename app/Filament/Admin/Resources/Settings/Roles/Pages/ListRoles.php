<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Roles\Pages;

use App\Filament\Admin\Resources\Settings\Roles\RoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class ListRoles extends ListRecords
{
    protected static string $resource = RoleResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.settings.roles.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.settings.roles.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            RoleResource::getUrl('index') => __('filament.settings.roles.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.settings.roles.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
