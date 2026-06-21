<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Teams\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingsTeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('code')->maxLength(64),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
