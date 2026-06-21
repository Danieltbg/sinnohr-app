<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Departments\Schemas;

use App\Models\MasterDepartment;
use App\Models\User;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament.employees.departments.form.general_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Group::make()
                                    ->schema([
                                        TextInput::make('name')
                                            ->label(__('filament.employees.departments.form.name'))
                                            ->required()
                                            ->autofocus()
                                            ->maxLength(255),
                                        Select::make('manager_id')
                                            ->label(__('filament.employees.departments.form.manager'))
                                            ->placeholder(__('filament.employees.departments.form.manager_placeholder'))
                                            ->options(fn (): array => User::query()
                                                ->where('is_active', true)
                                                ->orderBy('name')
                                                ->pluck('name', 'id')
                                                ->all())
                                            ->searchable()
                                            ->suffixIcon(Heroicon::OutlinedUser)
                                            ->native(false),
                                        ColorPicker::make('color')
                                            ->label(__('filament.employees.departments.form.color')),
                                    ]),
                                Group::make()
                                    ->schema([
                                        Select::make('parent_id')
                                            ->label(__('filament.employees.departments.form.parent_department'))
                                            ->placeholder(__('filament.employees.departments.form.parent_department_placeholder'))
                                            ->relationship(
                                                name: 'parent',
                                                titleAttribute: 'name',
                                                ignoreRecord: true,
                                            )
                                            ->searchable()
                                            ->preload()
                                            ->native(false),
                                        Select::make('company_name')
                                            ->label(__('filament.employees.departments.form.company'))
                                            ->placeholder(__('filament.employees.departments.form.company_placeholder'))
                                            ->options(fn (): array => self::companyOptions())
                                            ->searchable()
                                            ->prefixIcon(Heroicon::OutlinedBuildingOffice2)
                                            ->native(false),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return array<string, string>
     */
    private static function companyOptions(): array
    {
        $defaults = [
            'PT Pratesis' => 'PT Pratesis',
            'TechNova Solutions Pvt. Ltd.' => 'TechNova Solutions Pvt. Ltd.',
        ];

        $existing = MasterDepartment::query()
            ->whereNotNull('company_name')
            ->distinct()
            ->orderBy('company_name')
            ->pluck('company_name', 'company_name')
            ->all();

        return array_merge($defaults, $existing);
    }
}
