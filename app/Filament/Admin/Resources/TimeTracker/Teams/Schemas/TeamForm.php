<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Select::make('leader_id')
                    ->label('Leader')
                    ->required()
                    ->options(fn (): array => User::pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('members')
                    ->multiple()
                    ->relationship('members', 'name')
                    ->preload()
                    ->searchable(),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
