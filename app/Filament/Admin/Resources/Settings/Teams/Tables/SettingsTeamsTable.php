<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams\Tables;

use App\Filament\Admin\Resources\Settings\Teams\SettingsTeamResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsTeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => SettingsTeamResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('code')->searchable(),
                TextColumn::make('updated_at')->dateTime('M j, Y H:i:s')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
