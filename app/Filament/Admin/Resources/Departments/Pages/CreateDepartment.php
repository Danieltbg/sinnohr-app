<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Departments\Pages;

use App\Filament\Admin\Resources\Departments\DepartmentResource;
use App\Models\MasterDepartment;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Str;

class CreateDepartment extends CreateRecord
{
    protected static string $resource = DepartmentResource::class;

    protected static bool $canCreateAnother = true;

    public function getTitle(): string|Htmlable
    {
        return __('filament.employees.departments.create.title');
    }

    public function getBreadcrumb(): string
    {
        return __('filament.employees.departments.create.breadcrumb');
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (blank($data['code'] ?? null) && filled($data['name'] ?? null)) {
            $data['code'] = self::generateUniqueCode((string) $data['name']);
        }

        return $data;
    }

    private static function generateUniqueCode(string $name): string
    {
        $base = Str::upper(Str::limit(Str::slug($name, ''), 8, ''));
        $base = $base !== '' ? $base : 'DEPT';
        $code = $base;
        $suffix = 1;

        while (MasterDepartment::query()->where('code', $code)->exists()) {
            $code = $base.$suffix;
            $suffix++;
        }

        return $code;
    }
}
