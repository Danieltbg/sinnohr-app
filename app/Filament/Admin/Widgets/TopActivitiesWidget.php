<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Models\TimeEntry;
use Filament\Tables;
use Filament\Widgets\TableWidget as BaseTableWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class TopActivitiesWidget extends BaseTableWidget
{
    use OnlyAdminCanViewWidget;

    protected static ?int $sort = 3;

    protected int|string|array $columnSpan = 1;

    protected function getTableQuery(): Builder
    {
        return TimeEntry::where('user_id', auth()->id())
            ->selectRaw('MAX(id) as id, description, COUNT(*) as count, SUM(duration) as total_duration')
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->groupBy('description')
            ->orderByDesc('total_duration')
            ->limit(10);
    }

    public function getTableRecordKey(Model|array $record): string
    {
        return (string) ($record instanceof Model ? $record->getKey() : $record['id']);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('description')
                ->label('Activity')
                ->searchable(),
            Tables\Columns\TextColumn::make('count')
                ->label('Times Tracked')
                ->sortable(),
            Tables\Columns\TextColumn::make('total_duration')
                ->label('Total Time')
                ->formatStateUsing(fn (int $state): string => self::formatDuration($state))
                ->sortable(),
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
