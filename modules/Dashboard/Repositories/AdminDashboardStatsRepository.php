<?php

declare(strict_types=1);

namespace Modules\Dashboard\Repositories;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class AdminDashboardStatsRepository
{
    private const CACHE_KEY = 'admin.dashboard.dummy_stats';

    private const CACHE_TTL_SECONDS = 300;

    /**
     * @return array<string, int>
     */
    public function getStats(): array
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function (): array {
            $activeEmployees = User::query()
                ->where('role', RoleEnum::User)
                ->where('is_active', true)
                ->count();

            return [
                'employees' => max($activeEmployees, 128),
                'departments' => 12,
                'holidays' => 18,
                'paid_leaves' => 240,
                'on_leaves_today' => 7,
                'pending_leaves' => 14,
                'check_in_today' => 115,
                'check_out_today' => 98,
                'projects' => 24,
                'pending_projects' => 6,
            ];
        });
    }

    /**
     * @return array<string, mixed>
     */
    public function getAttendanceStatus(): array
    {
        return [
            'check_in' => '08:42',
            'check_out' => null,
            'status' => 'Checked in',
        ];
    }

    /**
     * @return array<string, list<int>>
     */
    public function getProjectChartData(): array
    {
        return [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'completed' => [42, 48, 55, 61, 68, 74],
            'in_progress' => [18, 20, 22, 19, 17, 15],
        ];
    }
}
