<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects\Tables;

use App\Filament\Admin\Resources\TimeTracker\Projects\ProjectResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => ProjectResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('client_name')
                    ->label('Client')
                    ->searchable(),
                TextColumn::make('created_at')->dateTime('M j, Y')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
