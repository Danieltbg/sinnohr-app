<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use App\Filament\Admin\Widgets\AttendanceWidget;
use App\Filament\Admin\Widgets\EmployeeStatsWidget;
use App\Filament\Admin\Widgets\LeaveStatsWidget;
use App\Filament\Admin\Widgets\ProjectChartWidget;
use App\Filament\Admin\Widgets\ProjectSummaryWidget;
use App\Filament\Admin\Widgets\RecentAttendanceTableWidget;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;
    use RegistersAdminNavigation;

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedHome;

    protected static ?string $navigationLabel = null;

    protected static ?int $navigationSort = -10;

    protected static ?string $title = null;

    public static function getNavigationLabel(): string
    {
        return __('filament.dashboard.navigation');
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament.dashboard.title');
    }

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns([
                        'default' => 1,
                        'sm' => 2,
                        'md' => 3,
                        'xl' => 6,
                    ])
                    ->schema([
                        Select::make('department')
                            ->label(__('filament.dashboard.filters.department'))
                            ->options([
                                'all' => __('filament.dashboard.filters.departments.all'),
                                'engineering' => __('filament.dashboard.filters.departments.engineering'),
                                'hr' => __('filament.dashboard.filters.departments.hr'),
                                'finance' => __('filament.dashboard.filters.departments.finance'),
                                'operations' => __('filament.dashboard.filters.departments.operations'),
                            ])
                            ->default('all')
                            ->native(false),
                        DatePicker::make('startDate')
                            ->label(__('filament.dashboard.filters.start_date'))
                            ->native(false)
                            ->default(now()->startOfMonth()),
                        DatePicker::make('endDate')
                            ->label(__('filament.dashboard.filters.end_date'))
                            ->native(false)
                            ->default(now()),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    /**
     * @return int|array<string, int|null>
     */
    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'md' => 2,
            'xl' => 4,
        ];
    }

    /**
     * @return array<class-string>
     */
    public function getWidgets(): array
    {
        return [
            EmployeeStatsWidget::class,
            LeaveStatsWidget::class,
            ProjectChartWidget::class,
            AttendanceWidget::class,
            ProjectSummaryWidget::class,
            RecentAttendanceTableWidget::class,
        ];
    }
}
