<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates\Pages;

use App\Filament\Admin\Concerns\HasRecruitmentApplicationsSidebar;
use App\Filament\Admin\Resources\Recruitments\Candidates\RecruitmentCandidateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListRecruitmentCandidates extends ListRecords
{
    use HasRecruitmentApplicationsSidebar;

    protected static string $resource = RecruitmentCandidateResource::class;

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
        return parent::getTableQuery()?->with('jobPosition');
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.recruitments.candidates.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.recruitments.candidates.breadcrumb_list');
    }

    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            route('filament.admin.pages.recruitments.applications') => __('filament.recruitments.applications.breadcrumb'),
            RecruitmentCandidateResource::getUrl('index') => __('filament.recruitments.candidates.breadcrumb'),
            $this->getBreadcrumb(),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('filament.recruitments.candidates.new'))
                ->icon(Heroicon::OutlinedPlus),
        ];
    }
}
