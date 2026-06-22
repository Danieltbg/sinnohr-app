<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans\Pages;

use App\Filament\Admin\Resources\ActivityPlans\ActivityPlanResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditActivityPlan extends EditRecord
{
    protected static string $resource = ActivityPlanResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.employees.configurations.activity_plans.edit.title', [
            'name' => $this->getRecord()->name,
        ]);
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.activity_plans.edit.breadcrumb');
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
