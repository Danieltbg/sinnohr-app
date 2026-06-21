<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Pages;

use App\Filament\Admin\Concerns\HasConfigurationSidebar;
use App\Filament\Admin\Resources\ConfigurationEntries\BaseConfigurationEntryResource;
use App\Models\EmployeeConfigurationEntry;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

abstract class ListConfigurationEntry extends ListRecords
{
    use HasConfigurationSidebar;

    protected string $view = 'filament.admin.pages.employees.configurations.resource-list';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getConfigurationViewData());
    }

    public function getTitle(): string | Htmlable
    {
        /** @var BaseConfigurationEntryResource $resource */
        $resource = static::getResource();

        return $resource::entryType()->label();
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.entries.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        /** @var BaseConfigurationEntryResource $resource */
        $resource = static::getResource();

        return [
            route('filament.admin.pages.employees.configurations') => __('filament.employees.configurations.breadcrumb'),
            $resource::getUrl('index') => $resource::entryType()->label(),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.employees.configurations.entries.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        /** @var BaseConfigurationEntryResource $resource */
        $resource = static::getResource();
        $type = $resource::entryType();

        return [
            'all' => Tab::make(__('filament.employees.configurations.tabs.all'))
                ->badge(fn (): int => once(fn (): int => EmployeeConfigurationEntry::query()->ofType($type)->count())),
            'archived' => Tab::make(__('filament.employees.configurations.tabs.archived'))
                ->badge(fn (): int => once(fn (): int => EmployeeConfigurationEntry::onlyTrashed()->where('type', $type->value)->count()))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
