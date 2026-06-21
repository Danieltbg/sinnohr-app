<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Candidates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RecruitmentCandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.recruitments.candidates.form.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('filament.recruitments.candidates.form.email'))
                            ->email()
                            ->maxLength(255),
                        Select::make('recruitment_job_position_id')
                            ->label(__('filament.recruitments.candidates.form.job_position'))
                            ->relationship('jobPosition', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('stage')
                            ->label(__('filament.recruitments.candidates.form.stage'))
                            ->default('screening')
                            ->maxLength(64),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
