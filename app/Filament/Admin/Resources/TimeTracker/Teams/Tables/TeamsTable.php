<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Tables;

use App\Filament\Admin\Resources\TimeTracker\Teams\TeamResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => TeamResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('leader.name')
                    ->label('Leader')
                    ->searchable(),
                TextColumn::make('members_count')
                    ->label('Members')
                    ->counts('members'),
                TextColumn::make('created_at')->dateTime('M j, Y')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
