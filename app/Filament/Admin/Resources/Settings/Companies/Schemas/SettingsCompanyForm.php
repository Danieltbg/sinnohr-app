<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Companies\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingsCompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('code')->maxLength(64),
                Toggle::make('is_active')->default(true),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
