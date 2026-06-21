<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('client_name')
                    ->label('Client Name')
                    ->required()
                    ->maxLength(255),
                Select::make('team_id')
                    ->relationship('team', 'name')
                    ->label('Assigned Team')
                    ->searchable()
                    ->preload()
                    ->nullable(),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
