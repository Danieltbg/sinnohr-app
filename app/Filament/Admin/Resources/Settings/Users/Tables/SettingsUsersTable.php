<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Users\Tables;

use App\Filament\Admin\Resources\Settings\Users\SettingsUserResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsUsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.settings.users.table.name'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => SettingsUserResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('email')
                    ->label(__('filament.settings.users.table.email'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(__('filament.settings.users.table.role'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state?->label() ?? '—'),
                TextColumn::make('updated_at')
                    ->label(__('filament.settings.users.table.updated_at'))
                    ->dateTime('M j, Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->searchable(['name', 'email'])
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
