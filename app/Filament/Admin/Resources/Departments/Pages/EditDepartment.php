<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Contracts\Support\Htmlable;

class EditDepartment extends EditRecord
{
    protected static string $resource = DepartmentResource::class;

    public function getTitle(): string | Htmlable
    {
        return __('filament.employees.departments.edit.title', ['name' => $this->getRecord()->name]);
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.departments.edit.breadcrumb');
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
