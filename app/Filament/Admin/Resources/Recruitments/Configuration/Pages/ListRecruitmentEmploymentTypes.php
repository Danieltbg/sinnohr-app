<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Configuration\Pages;

use App\Filament\Admin\Concerns\HasRecruitmentConfigurationSidebar;
use App\Filament\Admin\Resources\Recruitments\Configuration\RecruitmentEmploymentTypeResource;
use App\Models\EmployeeConfigurationEntry;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListRecruitmentEmploymentTypes extends ListRecords
{
    use HasRecruitmentConfigurationSidebar;

    protected static string $resource = RecruitmentEmploymentTypeResource::class;

    protected string $view = 'filament.admin.pages.recruitments.configuration.resource-list';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getRecruitmentConfigurationViewData());
    }

    public function getTitle(): string | Htmlable
    {
        return RecruitmentEmploymentTypeResource::entryType()->label();
    }

    public function getBreadcrumb(): string
    {
        return __('filament.recruitments.configuration.entries.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.recruitments.configuration') => __('filament.recruitments.configuration.breadcrumb'),
            RecruitmentEmploymentTypeResource::getUrl('index') => RecruitmentEmploymentTypeResource::entryType()->label(),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.recruitments.configuration.entries.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $type = RecruitmentEmploymentTypeResource::entryType();

        return [
            'all' => Tab::make(__('filament.recruitments.configuration.tabs.all'))
                ->badge(fn (): int => once(fn (): int => EmployeeConfigurationEntry::query()->ofType($type)->count())),
            'archived' => Tab::make(__('filament.recruitments.configuration.tabs.archived'))
                ->badge(fn (): int => once(fn (): int => EmployeeConfigurationEntry::onlyTrashed()->where('type', $type->value)->count()))
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
