<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\EmployeeSkills\Tables;

use App\Filament\Admin\Resources\Users\UserResource;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class EmployeeSkillsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label(__('filament.employees.reportings.skills.columns.employee'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('skill_name')
                    ->label(__('filament.employees.reportings.skills.columns.skill'))
                    ->searchable()
                    ->sortable(),
                ViewColumn::make('level')
                    ->label(__('filament.employees.reportings.skills.columns.level'))
                    ->view('filament.admin.tables.columns.skill-level'),
                ViewColumn::make('proficiency')
                    ->label(__('filament.employees.reportings.skills.columns.proficiency'))
                    ->view('filament.admin.tables.columns.skill-proficiency')
                    ->sortable(),
                ViewColumn::make('skill_type')
                    ->label(__('filament.employees.reportings.skills.columns.skill_type'))
                    ->view('filament.admin.tables.columns.skill-type')
                    ->searchable(),
            ])
            ->defaultGroup(
                Group::make('user.name')
                    ->label(__('filament.employees.reportings.skills.group_by.employee'))
                    ->titlePrefixedWithLabel(true)
                    ->collapsible(),
            )
            ->defaultSort('user.name', 'asc')
            ->searchable(['skill_name', 'skill_type', 'level', 'user.name'])
            ->groups([
                Group::make('user.name')
                    ->label(__('filament.employees.reportings.skills.group_by.employee'))
                    ->titlePrefixedWithLabel(true)
                    ->collapsible(),
                Group::make('skill_type')
                    ->label(__('filament.employees.reportings.skills.group_by.skill_type'))
                    ->titlePrefixedWithLabel(true)
                    ->collapsible(),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('view')
                        ->label(__('filament.employees.reportings.skills.actions.view'))
                        ->icon(Heroicon::OutlinedEye)
                        ->url(fn ($record): string => UserResource::getUrl('edit', ['record' => $record->user_id])),
                    Action::make('edit')
                        ->label(__('filament.employees.reportings.skills.actions.edit'))
                        ->icon(Heroicon::OutlinedPencilSquare)
                        ->url(fn ($record): string => UserResource::getUrl('edit', ['record' => $record->user_id])),
                    DeleteAction::make(),
                ])
                    ->icon(Heroicon::OutlinedEllipsisVertical)
                    ->iconButton()
                    ->tooltip(__('filament.employees.reportings.skills.actions.menu')),
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
