<?php

declare(strict_types=1);

namespace App\Services\Admin;

use Filament\Support\Icons\Heroicon;

class PluginRegistry
{
    /**
     * @return list<array{
     *     id: string,
     *     name: string,
     *     version: string,
     *     description: string,
     *     icon: Heroicon,
     *     color: string,
     *     accent: string,
     *     installed: bool,
     *     dependencies_count: int,
     *     url: string|null
     * }>
     */
    public function all(): array
    {
        return [
            $this->plugin(
                'dashboard',
                Heroicon::OutlinedHome,
                '#0070F2',
                '#FDB421',
                true,
                0,
                'filament.admin.pages.dashboard',
            ),
            $this->plugin(
                'employees',
                Heroicon::OutlinedUsers,
                '#0070F2',
                '#22c55e',
                true,
                1,
                'filament.admin.pages.employee-management',
            ),
            $this->plugin(
                'attendance',
                Heroicon::OutlinedClock,
                '#0891b2',
                '#a3e635',
                true,
                1,
                'filament.admin.pages.attendance-management',
            ),
            $this->plugin(
                'time_off',
                Heroicon::OutlinedCalendarDays,
                '#ea580c',
                '#4ade80',
                true,
                1,
                'filament.admin.pages.leave',
            ),
            $this->plugin(
                'recruitment',
                Heroicon::OutlinedBriefcase,
                '#7c3aed',
                '#f472b6',
                true,
                1,
                'filament.admin.pages.recruitment',
            ),
            $this->plugin(
                'company',
                Heroicon::OutlinedBuildingOffice2,
                '#2563eb',
                '#fbbf24',
                true,
                0,
                'filament.admin.pages.company-management',
            ),
            $this->plugin(
                'projects',
                Heroicon::OutlinedSquare3Stack3d,
                '#6366f1',
                '#fb923c',
                true,
                0,
                'filament.admin.pages.dashboard',
            ),
            $this->plugin(
                'identity_api',
                Heroicon::OutlinedKey,
                '#0284c7',
                '#fde047',
                true,
                1,
                null,
            ),
            $this->plugin(
                'portal',
                Heroicon::OutlinedGlobeAlt,
                '#059669',
                '#38bdf8',
                true,
                1,
                null,
            ),
            $this->plugin(
                'notifications',
                Heroicon::OutlinedBell,
                '#db2777',
                '#fcd34d',
                true,
                0,
                null,
            ),
            $this->plugin(
                'payroll',
                Heroicon::OutlinedBanknotes,
                '#16a34a',
                '#86efac',
                false,
                2,
                null,
            ),
            $this->plugin(
                'performance',
                Heroicon::OutlinedChartBar,
                '#4f46e5',
                '#c4b5fd',
                false,
                1,
                null,
            ),
            $this->plugin(
                'inventory',
                Heroicon::OutlinedCube,
                '#0d9488',
                '#5eead4',
                false,
                1,
                null,
            ),
            $this->plugin(
                'accounting',
                Heroicon::OutlinedCalculator,
                '#1d4ed8',
                '#93c5fd',
                false,
                2,
                null,
            ),
            $this->plugin(
                'website',
                Heroicon::OutlinedComputerDesktop,
                '#e11d48',
                '#fda4af',
                false,
                0,
                null,
            ),
            $this->plugin(
                'settings',
                Heroicon::OutlinedCog6Tooth,
                '#64748b',
                '#cbd5e1',
                true,
                0,
                null,
            ),
        ];
    }

    /**
     * @return array{
     *     id: string,
     *     name: string,
     *     version: string,
     *     description: string,
     *     icon: Heroicon,
     *     color: string,
     *     accent: string,
     *     installed: bool,
     *     dependencies_count: int,
     *     url: string|null
     * }
     */
    private function plugin(
        string $id,
        Heroicon $icon,
        string $color,
        string $accent,
        bool $installed,
        int $dependenciesCount,
        ?string $routeName,
    ): array {
        return [
            'id' => $id,
            'name' => __("filament.plugins.items.{$id}.name"),
            'version' => __('filament.plugins.version', ['version' => '1.0.0']),
            'description' => __("filament.plugins.items.{$id}.description"),
            'icon' => $icon,
            'color' => $color,
            'accent' => $accent,
            'installed' => $installed,
            'dependencies_count' => $dependenciesCount,
            'url' => $routeName !== null ? route($routeName) : null,
        ];
    }
}
