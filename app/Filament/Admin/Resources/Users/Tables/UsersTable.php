<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Users\Tables;

use App\Enums\EmployeeBadgeEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                View::make('filament.admin.tables.columns.employee-card'),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 4,
            ])
            ->defaultSort('name')
            ->searchable(['name', 'email', 'job_title', 'phone'])
            ->groups([
                Group::make('employee_badge')
                    ->label(__('filament.employees.group_by.badge'))
                    ->getTitleFromRecordUsing(fn ($record): string => $record->employee_badge?->label() ?? '—'),
                Group::make('job_title')
                    ->label(__('filament.employees.group_by.job_title')),
            ])
            ->filters([
                SelectFilter::make('employee_badge')
                    ->label(__('filament.employees.filters.badge'))
                    ->options(collect(EmployeeBadgeEnum::cases())->mapWithKeys(
                        fn (EmployeeBadgeEnum $case): array => [$case->value => $case->label()],
                    )),
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
