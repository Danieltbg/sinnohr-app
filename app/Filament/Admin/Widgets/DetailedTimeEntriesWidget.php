<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Models\TimeEntry;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;

class DetailedTimeEntriesWidget extends BaseTableWidget
{
    use OnlyAdminCanViewWidget;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return TimeEntry::where('user_id', auth()->id())
            ->with('project')
            ->orderByDesc('date')
            ->orderByDesc('start_time');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('date')
                ->label('Date')
                ->date('M j, Y')
                ->sortable(),
            Tables\Columns\TextColumn::make('description')
                ->label('Description')
                ->searchable()
                ->limit(40),
            Tables\Columns\TextColumn::make('project.name')
                ->label('Project')
                ->badge()
                ->color('info'),
            Tables\Columns\TextColumn::make('time_range')
                ->label('Time')
                ->getStateUsing(fn (TimeEntry $record): string => sprintf(
                    '%s - %s',
                    $record->start_time?->format('H:i') ?? '--',
                    $record->end_time?->format('H:i') ?? '--',
                )),
            Tables\Columns\TextColumn::make('duration')
                ->label('Duration')
                ->formatStateUsing(fn (int $state): string => self::formatDuration($state))
                ->sortable(),
            Tables\Columns\IconColumn::make('is_billable')
                ->label('Billable')
                ->boolean(),
        ];
    }

    protected function getTableDefaultSort(): ?array
    {
        return ['date' => 'desc', 'start_time' => 'desc'];
    }

    protected function getTableFilters(): array
    {
        return [
            Tables\Filters\SelectFilter::make('project_id')
                ->label('Project')
                ->relationship('project', 'name'),
            Tables\Filters\Filter::make('is_billable')
                ->label('Billable only')
                ->query(fn (Builder $query): Builder => $query->where('is_billable', true)),
        ];
    }

    public static function formatDuration(int $seconds): string
    {
        return sprintf(
            '%02d:%02d:%02d',
            intdiv($seconds, 3600),
            intdiv($seconds % 3600, 60),
            $seconds % 60,
        );
    }
}
