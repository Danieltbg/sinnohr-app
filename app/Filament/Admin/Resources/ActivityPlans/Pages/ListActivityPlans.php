<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans\Pages;

use App\Filament\Admin\Concerns\HasConfigurationSidebar;
use App\Filament\Admin\Resources\ActivityPlans\ActivityPlanResource;
use App\Models\ActivityPlan;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListActivityPlans extends ListRecords
{
    use HasConfigurationSidebar;

    protected static string $resource = ActivityPlanResource::class;

    protected string $view = 'filament.admin.pages.employees.configurations.resource-list';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getConfigurationViewData());
    }

    public function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->with(['department', 'manager']);
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.employees.configurations.activity_plans.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.activity_plans.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.employees.configurations') => __('filament.employees.configurations.breadcrumb'),
            ActivityPlanResource::getUrl('index') => __('filament.employees.configurations.activity_plans.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.employees.configurations.activity_plans.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'all' => Tab::make(__('filament.employees.configurations.tabs.all'))
                ->badge(fn (): int => once(fn (): int => ActivityPlan::query()->count())),
            'archived' => Tab::make(__('filament.employees.configurations.tabs.archived'))
                ->badge(fn (): int => once(fn (): int => ActivityPlan::onlyTrashed()->count()))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
