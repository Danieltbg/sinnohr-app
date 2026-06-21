<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions\Schemas;

use App\Models\MasterDepartment;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class RecruitmentJobPositionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament.recruitments.job_positions.form.general_information'))
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('filament.recruitments.job_positions.form.name'))
                                    ->required()
                                    ->autofocus()
                                    ->maxLength(255),
                                Select::make('manager_id')
                                    ->label(__('filament.recruitments.job_positions.form.manager'))
                                    ->placeholder(__('filament.recruitments.job_positions.form.manager_placeholder'))
                                    ->options(fn (): array => User::query()
                                        ->where('is_active', true)
                                        ->orderBy('name')
                                        ->pluck('name', 'id')
                                        ->all())
                                    ->searchable()
                                    ->suffixIcon(Heroicon::OutlinedUser)
                                    ->native(false),
                                Select::make('master_department_id')
                                    ->label(__('filament.recruitments.job_positions.form.department'))
                                    ->placeholder(__('filament.recruitments.job_positions.form.department_placeholder'))
                                    ->relationship('department', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->native(false),
                                Select::make('company_name')
                                    ->label(__('filament.recruitments.job_positions.form.company'))
                                    ->placeholder(__('filament.recruitments.job_positions.form.company_placeholder'))
                                    ->options(fn (): array => self::companyOptions())
                                    ->searchable()
                                    ->prefixIcon(Heroicon::OutlinedBuildingOffice2)
                                    ->native(false),
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
            'BlueOcean Technologies Inc.' => 'BlueOcean Technologies Inc.',
            'PT Pratesis' => 'PT Pratesis',
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
