<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ConfigurationEntryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('filament.employees.configurations.entries.form.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.employees.configurations.entries.form.name'))
                            ->required()
                            ->maxLength(255),
                        Toggle::make('is_active')
                            ->label(__('filament.employees.configurations.entries.form.is_active'))
                            ->default(true),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
