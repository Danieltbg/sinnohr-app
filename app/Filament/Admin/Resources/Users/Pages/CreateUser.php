<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Pages;

use App\Enums\EmployeeBadgeEnum;
use App\Enums\RoleEnum;
use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function getTitle(): string|Htmlable
    {
        return __('filament.employees.create.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.create.breadcrumb');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['role'] ??= RoleEnum::User->value;
        $data['employee_badge'] ??= EmployeeBadgeEnum::Employee->value;
        $data['is_active'] ??= true;
        $data['timezone'] ??= 'UTC';

        return $data;
    }
}
