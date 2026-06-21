<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\Applicants\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class RecruitmentApplicantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('filament.recruitments.applicants.form.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label(__('filament.recruitments.applicants.form.email'))
                            ->email()
                            ->maxLength(255),
                        Select::make('recruitment_job_position_id')
                            ->label(__('filament.recruitments.applicants.form.job_position'))
                            ->relationship('jobPosition', 'name')
                            ->searchable()
                            ->preload()
                            ->native(false),
                        TextInput::make('status')
                            ->label(__('filament.recruitments.applicants.form.status'))
                            ->default('new')
                            ->maxLength(64),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
