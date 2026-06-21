<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\EmployeeSkills\Pages;

use App\Filament\Admin\Resources\EmployeeSkills\EmployeeSkillResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListEmployeeSkills extends ListRecords
{
    protected static string $resource = EmployeeSkillResource::class;

    protected string $view = 'filament.admin.pages.employees.reportings.skills';

    public function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->with('user');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.employees.reportings.skills.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.reportings.skills.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.employees.reportings') => __('filament.employees.reportings.breadcrumb'),
            EmployeeSkillResource::getUrl('index') => __('filament.employees.reportings.skills.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'default' => Tab::make(__('filament.employees.reportings.skills.tabs.default'))
                ->icon(Heroicon::OutlinedQueueList),
            'with_skill' => Tab::make(__('filament.employees.reportings.skills.tabs.with_skill'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereNotNull('proficiency')),
            'without_skill' => Tab::make(__('filament.employees.reportings.skills.tabs.without_skill'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->whereNull('proficiency')),
            'archived' => Tab::make(__('filament.employees.reportings.skills.tabs.archived'))
                ->icon(Heroicon::OutlinedTrash)
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
