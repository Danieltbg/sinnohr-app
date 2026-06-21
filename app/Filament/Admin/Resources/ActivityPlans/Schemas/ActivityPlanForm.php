<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class ActivityPlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Section::make(__('filament.employees.configurations.activity_plans.form.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.employees.configurations.activity_plans.form.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('master_department_id')
                            ->label(__('filament.employees.configurations.activity_plans.form.department'))
                            ->relationship('department', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Select::make('manager_id')
                            ->label(__('filament.employees.configurations.activity_plans.form.manager'))
                            ->options(fn (): array => User::query()
                                ->where('is_active', true)
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->searchable()
                            ->suffixIcon(Heroicon::OutlinedUser)
                            ->native(false),
                        TextInput::make('company_name')
                            ->label(__('filament.employees.configurations.activity_plans.form.company'))
                            ->maxLength(255)
                            ->prefixIcon(Heroicon::OutlinedBuildingOffice2)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label(__('filament.employees.configurations.activity_plans.form.is_active'))
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
