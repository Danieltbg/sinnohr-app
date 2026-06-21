<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RecruitmentCandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.recruitments.candidates.table.name'))
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('filament.recruitments.candidates.table.email'))
                    ->searchable(),
                TextColumn::make('jobPosition.name')
                    ->label(__('filament.recruitments.candidates.table.job_position'))
                    ->sortable(),
                TextColumn::make('stage')
                    ->label(__('filament.recruitments.candidates.table.stage'))
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
