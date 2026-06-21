<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.employees.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.breadcrumb_list');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.employees.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'default' => Tab::make(__('filament.employees.tabs.default'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_active', true)),
            'my_team' => Tab::make(__('filament.employees.tabs.my_team'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_active', true)),
            'my_department' => Tab::make(__('filament.employees.tabs.my_department'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->where('is_active', true)),
            'archived' => Tab::make(__('filament.employees.tabs.archived'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
            'newly_hired' => Tab::make(__('filament.employees.tabs.newly_hired'))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query
                    ->where('is_active', true)
                    ->where('created_at', '>=', now()->subDays(30))),
        ];
    }
}
