<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans\Pages;

use App\Filament\Admin\Resources\ActivityPlans\ActivityPlanResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateActivityPlan extends CreateRecord
{
    protected static string $resource = ActivityPlanResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.employees.configurations.activity_plans.create.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.configurations.activity_plans.create.breadcrumb');
    }
}
