<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Roles\Tables;

use App\Filament\Admin\Resources\Settings\Roles\RoleResource;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RolesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.settings.roles.table.name'))
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => RoleResource::getUrl('edit', ['record' => $record]))
                    ->color('primary')
                    ->weight('medium'),
                TextColumn::make('guard_name')
                    ->label(__('filament.settings.roles.table.guard_name'))
                    ->badge()
                    ->color('info'),
                TextColumn::make('permissions_count')
                    ->label(__('filament.settings.roles.table.permissions'))
                    ->badge()
                    ->color('success')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label(__('filament.settings.roles.table.updated_at'))
                    ->dateTime('M j, Y H:i:s')
                    ->sortable(),
            ])
            ->defaultSort('name')
            ->searchable(['name', 'slug', 'guard_name'])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                EditAction::make()
                    ->link()
                    ->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()
                    ->link()
                    ->color('danger')
                    ->icon(Heroicon::OutlinedTrash),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
