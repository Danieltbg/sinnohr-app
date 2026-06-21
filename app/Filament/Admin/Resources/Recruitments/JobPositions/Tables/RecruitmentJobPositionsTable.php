<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\Recruitments\JobPositions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class RecruitmentJobPositionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                View::make('filament.admin.tables.columns.recruitment-job-position-card'),
            ])
            ->contentGrid([
                'md' => 2,
                'xl' => 2,
            ])
            ->defaultSort('name')
            ->searchable(['name', 'company_name'])
            ->filters([
                TrashedFilter::make(),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->paginated([12, 24, 48]);
    }
}
