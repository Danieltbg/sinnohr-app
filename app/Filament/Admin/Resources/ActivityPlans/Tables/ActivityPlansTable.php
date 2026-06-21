<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ActivityPlans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class ActivityPlansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.employees.configurations.activity_plans.columns.name'))
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('department.name')
                    ->label(__('filament.employees.configurations.activity_plans.columns.department'))
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('manager.name')
                    ->label(__('filament.employees.configurations.activity_plans.columns.manager'))
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                TextColumn::make('company_name')
                    ->label(__('filament.employees.configurations.activity_plans.columns.company'))
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),
                IconColumn::make('is_active')
                    ->label(__('filament.employees.configurations.activity_plans.columns.status'))
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->defaultSort('name')
            ->searchable(['name', 'company_name'])
            ->groups([
                Group::make('department.name')
                    ->label(__('filament.employees.configurations.activity_plans.group_by.department'))
                    ->collapsible(),
                Group::make('company_name')
                    ->label(__('filament.employees.configurations.activity_plans.group_by.company'))
                    ->collapsible(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(10)
            ->paginated([10, 25, 50]);
    }
}
