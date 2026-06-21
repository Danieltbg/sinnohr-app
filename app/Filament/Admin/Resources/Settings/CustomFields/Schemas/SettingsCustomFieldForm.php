<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\CustomFields\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SettingsCustomFieldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make()->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('model_type')->required()->maxLength(128),
                Select::make('field_type')
                    ->options([
                        'text' => 'Text',
                        'number' => 'Number',
                        'date' => 'Date',
                        'select' => 'Select',
                        'checkbox' => 'Checkbox',
                    ])
                    ->default('text')
                    ->native(false),
                Toggle::make('is_active')->default(true),
            ])->columns(2)->columnSpanFull(),
        ]);
    }
}
