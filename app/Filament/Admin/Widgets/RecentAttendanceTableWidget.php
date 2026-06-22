<?php

declare(strict_types=1);

namespace App\Filament\Admin\Widgets;

use App\Enums\RoleEnum;
use App\Filament\Admin\Concerns\OnlyAdminCanViewWidget;
use App\Models\User;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\TableWidget;

class RecentAttendanceTableWidget extends TableWidget
{
    use InteractsWithPageFilters;
    use OnlyAdminCanViewWidget;

    protected static bool $isLazy = false;

    protected static ?int $sort = 6;

    protected ?string $pollingInterval = '15s';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->heading(__('filament.widgets.recent_attendance.heading'))
            ->query(
                User::query()
                    ->where('role', RoleEnum::User)
                    ->where('is_active', true)
                    ->latest('updated_at')
            )
            ->columns([
                TextColumn::make('name')
                    ->label(__('filament.widgets.recent_attendance.employee'))
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->placeholder('—'),
                TextColumn::make('email')
                    ->label(__('filament.widgets.recent_attendance.email'))
                    ->placeholder('—'),
                TextColumn::make('updated_at')
                    ->label(__('filament.widgets.recent_attendance.last_activity'))
                    ->since()
                    ->placeholder('—')
                    ->sortable(),
            ])
            ->defaultPaginationPageOption(5)
            ->paginated([5]);
    }
}
