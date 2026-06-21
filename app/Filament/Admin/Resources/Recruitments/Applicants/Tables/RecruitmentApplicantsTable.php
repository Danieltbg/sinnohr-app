<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Applicants\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RecruitmentApplicantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.recruitments.applicants.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('filament.recruitments.applicants.table.email'))
                    ->searchable(),
                TextColumn::make('jobPosition.name')
                    ->label(__('filament.recruitments.applicants.table.job_position'))
                    ->sortable(),
                TextColumn::make('status')
                    ->label(__('filament.recruitments.applicants.table.status'))
                    ->badge(),
            ])
            ->defaultSort('name')
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
