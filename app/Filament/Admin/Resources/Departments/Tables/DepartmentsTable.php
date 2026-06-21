<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Departments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class DepartmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                View::make('filament.admin.tables.columns.department-card'),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])
            ->defaultSort('name')
            ->searchable(['name', 'code', 'company_name'])
            ->groups([
                Group::make('company_name')
                    ->label(__('filament.employees.departments.group_by.company'))
                    ->getTitleFromRecordUsing(fn ($record): string => $record->company_name ?? '—'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->paginated([12, 24, 48]);
    }
}
