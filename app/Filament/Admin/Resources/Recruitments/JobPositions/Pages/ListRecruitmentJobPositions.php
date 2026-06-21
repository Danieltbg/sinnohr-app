<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions\Pages;

use App\Filament\Admin\Concerns\HasRecruitmentApplicationsSidebar;
use App\Filament\Admin\Resources\Recruitments\JobPositions\RecruitmentJobPositionResource;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListRecruitmentJobPositions extends ListRecords
{
    use HasRecruitmentApplicationsSidebar;

    protected static string $resource = RecruitmentJobPositionResource::class;

    protected string $view = 'filament.admin.pages.recruitments.applications.resource-list';

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        return array_merge(parent::getViewData(), $this->getRecruitmentApplicationsViewData());
    }

    public function getTableQuery(): ?Builder
    {
        return parent::getTableQuery()?->with('manager');
    }

    public function getTitle(): string | Htmlable
    {
        return __('filament.recruitments.job_positions.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.recruitments.job_positions.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.recruitments.applications') => __('filament.recruitments.applications.breadcrumb'),
            RecruitmentJobPositionResource::getUrl('index') => __('filament.recruitments.job_positions.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.recruitments.job_positions.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        return [
            'default' => Tab::make(__('filament.recruitments.job_positions.tabs.default'))
                ->icon(Heroicon::OutlinedQueueList),
            'my_department' => Tab::make(__('filament.recruitments.job_positions.tabs.my_department'))
                ->icon(Heroicon::OutlinedUserGroup)
                ->modifyQueryUsing(function (Builder $query): Builder {
                    $user = auth()->user();

                    if (! $user instanceof User) {
                        return $query->whereRaw('1 = 0');
                    }

                    return $query->where(function (Builder $inner) use ($user): void {
                        $inner
                            ->where('manager_id', $user->id)
                            ->when(
                                filled($user->master_department_id),
                                fn (Builder $departmentQuery): Builder => $departmentQuery->orWhere('master_department_id', $user->master_department_id),
                            );
                    });
                }),
            'archived' => Tab::make(__('filament.recruitments.job_positions.tabs.archived'))
                ->icon(Heroicon::OutlinedTrash)
                ->modifyQueryUsing(fn (Builder $query): Builder => $query->onlyTrashed()),
        ];
    }
}
