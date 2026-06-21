<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Settings\Roles\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RoleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make(__('filament.settings.roles.form.general'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.settings.roles.form.name'))
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        TextInput::make('slug')
                            ->label(__('filament.settings.roles.form.slug'))
                            ->maxLength(255),
                        TextInput::make('guard_name')
                            ->label(__('filament.settings.roles.form.guard_name'))
                            ->default('web')
                            ->required()
                            ->maxLength(64),
                        TextInput::make('permissions_count')
                            ->label(__('filament.settings.roles.form.permissions_count'))
                            ->numeric()
                            ->default(0)
                            ->minValue(0),
                        Textarea::make('description')
                            ->label(__('filament.settings.roles.form.description'))
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
