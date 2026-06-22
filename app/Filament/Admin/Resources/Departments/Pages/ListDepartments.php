<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListDepartments extends ListRecords
{
    protected static string $resource = DepartmentResource::class;

    public function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->with('manager');
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.employees.departments.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.departments.breadcrumb_list');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.employees.departments.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'default' => Tab::make(__('filament.employees.departments.tabs.default'))
                ->icon(Heroicon::OutlinedQueueList),
            'archived' => Tab::make(__('filament.employees.departments.tabs.archived'))
                ->icon(Heroicon::OutlinedTrash)
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
