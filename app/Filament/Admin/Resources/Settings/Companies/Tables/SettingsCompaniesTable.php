<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies\Tables;

use App\Filament\Admin\Resources\Settings\Companies\SettingsCompanyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SettingsCompaniesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->url(fn ($record): string => SettingsCompanyResource::getUrl('edit', ['record' => $record]))
                    ->color('primary'),
                TextColumn::make('code')->searchable(),
                IconColumn::make('is_active')->boolean(),
                TextColumn::make('updated_at')->dateTime('M j, Y H:i:s')->sortable(),
            ])
            ->defaultSort('name')
            ->recordActions([
                EditAction::make()->link()->icon(Heroicon::OutlinedPencilSquare),
                DeleteAction::make()->link()->color('danger')->icon(Heroicon::OutlinedTrash),
            ]);
    }
}
