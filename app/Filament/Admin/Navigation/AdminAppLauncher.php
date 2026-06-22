<?php

declare(strict_types=1);

namespace App\Filament\Admin\Navigation;

use Filament\Support\Icons\Heroicon;

final class AdminAppLauncher
{
    private const DASHBOARD_ROUTE = 'filament.admin.pages.dashboard';

    /**
     * @return list<array{label: string, url: string, icon: string|Heroicon, color: string, accent: string}>
     */
    public static function items(): array
    {
        return once(function (): array {
            if (auth()->user()?->isAdmin() === false) {
                return [
                    self::moduleItem('activity_team', 'filament.admin.pages.time-tracker.activity-team', Heroicon::OutlinedUsers, '#0d9488', '#2dd4bf'),
                ];
            }

            return [
                self::moduleItem('dashboard', self::DASHBOARD_ROUTE, Heroicon::OutlinedHome, '#0070F2', '#FDB421'),
                self::moduleItem('company_management', 'filament.admin.pages.company-management', Heroicon::OutlinedBuildingOffice2, '#2563eb', '#fbbf24'),
                self::moduleItem('branch', 'filament.admin.pages.branch', Heroicon::OutlinedMapPin, '#0ea5e9', '#fde047'),
                self::moduleItem('division', 'filament.admin.pages.division', Heroicon::OutlinedSquares2x2, '#6366f1', '#fb923c'),
                self::moduleItem('team', 'filament.admin.pages.team', Heroicon::OutlinedUserGroup, '#8b5cf6', '#34d399'),
                self::moduleItem('employee_management', 'filament.admin.pages.employee-management', Heroicon::OutlinedUsers, '#0070F2', '#22c55e'),
                self::moduleItem('employees', 'filament.admin.resources.users.index', Heroicon::OutlinedUserGroup, '#0284c7', '#f59e0b'),
                self::moduleItem('recruitments', 'filament.admin.resources.recruitments.applications.job-positions.index', Heroicon::OutlinedBriefcase, '#7c3aed', '#f472b6'),
                self::moduleItem('time_tracker', 'filament.admin.pages.time-tracker', Heroicon::OutlinedPlay, '#0d9488', '#2dd4bf'),
                self::moduleItem('shift_management', 'filament.admin.pages.shift-management', Heroicon::OutlinedArrowsRightLeft, '#0891b2', '#a3e635'),
                self::moduleItem('attendance_management', 'filament.admin.pages.attendance-management', Heroicon::OutlinedClock, '#0070F2', '#FDB421'),
                self::moduleItem('attendance', 'filament.admin.pages.attendance.my-attendance.dashboard', Heroicon::OutlinedClock, '#059669', '#fcd34d'),
                self::moduleItem('team_meeting', 'filament.admin.pages.team-meeting', Heroicon::OutlinedCalendar, '#db2777', '#38bdf8'),
                self::moduleItem('leave', 'filament.admin.pages.leave', Heroicon::OutlinedCalendarDays, '#ea580c', '#4ade80'),
                self::moduleItem('plugins', 'filament.admin.pages.plugins', Heroicon::OutlinedPuzzlePiece, '#64748b', '#94a3b8'),
                self::moduleItem('settings', 'filament.admin.resources.settings.roles.index', Heroicon::OutlinedCog6Tooth, '#475569', '#cbd5e1'),
            ];
        });
    }

    /**
     * Horizontal tabs for the active module group (context-aware).
     *
     * @return list<array{label: string, url: string}>
     */
    public static function contextualTabs(): array
    {
        return once(function (): array {
            $groupKey = self::resolveTabGroupKey();

            $tabs = self::tabGroups()[$groupKey]['tabs'] ?? self::tabGroups()['dashboard']['tabs'];

            if (auth()->user()?->isAdmin() === false) {
                $tabs = array_values(array_filter(
                    $tabs,
                    fn (array $tab): bool => $tab[1] === 'filament.admin.pages.time-tracker.activity-team',
                ));
            }

            return array_map(
                fn (array $tab): array => self::tabItem($tab[0], $tab[1]),
                $tabs,
            );
        });
    }

    public static function isActive(string $url): bool
    {
        return self::urlMatches(self::currentPath(), self::urlPath($url));
    }

    public static function isTabActive(string $url): bool
    {
        return self::urlMatches(self::currentPath(), self::urlPath($url));
    }

    /**
     * @return array<string, array{route_names: list<string>, tabs: list<array{0: string, 1: string}>}>
     */
    private static function tabGroups(): array
    {
        return once(fn (): array => [
            'plugins' => [
                'route_names' => [
                    'filament.admin.pages.plugins',
                ],
                'tabs' => [
                    ['plugins', 'filament.admin.pages.plugins'],
                ],
            ],
            'time_tracker' => [
                'route_names' => [
                    'filament.admin.pages.time-tracker',
                    'filament.admin.pages.time-tracker.timesheet',
                    'filament.admin.pages.time-tracker.overtime',
                    'filament.admin.pages.time-tracker.project-team',
                    'filament.admin.pages.time-tracker.reports',
                    'filament.admin.resources.time-tracker.projects.index',
                    'filament.admin.resources.time-tracker.teams.index',
                    'filament.admin.pages.time-tracker.activity-monitor',
                    'filament.admin.pages.time-tracker.activity-team',
                    'filament.admin.pages.time-tracker.money-time',
                ],
                'tabs' => [
                    ['time_tracker_hub', 'filament.admin.pages.time-tracker'],
                    ['time_tracker_timesheet', 'filament.admin.pages.time-tracker.timesheet'],
                    ['time_tracker_overtime', 'filament.admin.pages.time-tracker.overtime'],
                    ['time_tracker_project_team', 'filament.admin.pages.time-tracker.project-team'],
                    ['time_tracker_projects', 'filament.admin.resources.time-tracker.projects.index'],
                    ['time_tracker_teams', 'filament.admin.resources.time-tracker.teams.index'],
                    ['time_tracker_reports', 'filament.admin.pages.time-tracker.reports'],
                    ['activity_monitor', 'filament.admin.pages.time-tracker.activity-monitor'],
                    ['activity_team', 'filament.admin.pages.time-tracker.activity-team'],
                    ['money_time', 'filament.admin.pages.time-tracker.money-time'],
                ],
            ],
            'time_attendance' => [
                'route_names' => [
                    'filament.admin.pages.shift-management',
                    'filament.admin.pages.attendance-management',
                    'filament.admin.pages.team-meeting',
                    'filament.admin.pages.leave',
                ],
                'tabs' => [
                    ['shift_management', 'filament.admin.pages.shift-management'],
                    ['attendance_management', 'filament.admin.pages.attendance-management'],
                    ['team_meeting', 'filament.admin.pages.team-meeting'],
                    ['leave', 'filament.admin.pages.leave'],
                ],
            ],
            'attendance' => [
                'route_names' => [
                    'filament.admin.pages.attendance',
                    'filament.admin.pages.visit-attendance',
                    'filament.admin.pages.attendance.my-attendance',
                    'filament.admin.pages.attendance.my-attendance.dashboard',
                    'filament.admin.pages.attendance.my-attendance.records',
                    'filament.admin.pages.attendance.my-attendance.allocation',
                    'filament.admin.pages.attendance.overview',
                    'filament.admin.pages.attendance.management',
                    'filament.admin.pages.attendance.reporting',
                    'filament.admin.pages.attendance.configuration',
                ],
                'tabs' => [
                    ['my_attendance', 'filament.admin.pages.attendance.my-attendance.dashboard'],
                    ['attendance_overview', 'filament.admin.pages.attendance.overview'],
                    ['attendance_management_tab', 'filament.admin.pages.attendance.management'],
                    ['attendance_reporting', 'filament.admin.pages.attendance.reporting'],
                    ['attendance_configuration', 'filament.admin.pages.attendance.configuration'],
                ],
            ],
            'employee' => [
                'route_names' => [
                    'filament.admin.resources.users.index',
                    'filament.admin.resources.employees.departments.index',
                    'filament.admin.pages.employees.reportings',
                    'filament.admin.resources.employees.reportings.skills.index',
                    'filament.admin.pages.employees.configurations',
                    'filament.admin.resources.employees.configurations.activity-plans.index',
                    'filament.admin.resources.employees.configurations.departure-reasons.index',
                    'filament.admin.resources.employees.configurations.tags.index',
                    'filament.admin.resources.employees.configurations.work-locations.index',
                    'filament.admin.resources.employees.configurations.skill-types.index',
                    'filament.admin.resources.employees.configurations.employment-types.index',
                    'filament.admin.resources.employees.configurations.job-positions.index',
                ],
                'tabs' => [
                    ['employees', 'filament.admin.resources.users.index'],
                    ['departments', 'filament.admin.resources.employees.departments.index'],
                    ['reportings', 'filament.admin.pages.employees.reportings'],
                    ['configurations', 'filament.admin.pages.employees.configurations'],
                ],
            ],
            'recruitment' => [
                'route_names' => [
                    'filament.admin.pages.recruitment',
                    'filament.admin.pages.recruitments.applications',
                    'filament.admin.resources.recruitments.applications.job-positions.index',
                    'filament.admin.resources.recruitments.applications.applicants.index',
                    'filament.admin.resources.recruitments.applications.candidates.index',
                    'filament.admin.pages.recruitments.configuration',
                    'filament.admin.resources.recruitments.configuration.employment-types.index',
                ],
                'tabs' => [
                    ['applications', 'filament.admin.resources.recruitments.applications.job-positions.index'],
                    ['configuration', 'filament.admin.pages.recruitments.configuration'],
                ],
            ],
            'settings' => [
                'route_names' => [
                    'filament.admin.pages.settings',
                    'filament.admin.resources.settings.roles.index',
                    'filament.admin.resources.settings.companies.index',
                    'filament.admin.resources.settings.teams.index',
                    'filament.admin.resources.settings.users.index',
                    'filament.admin.resources.settings.custom-fields.index',
                    'filament.admin.pages.settings.general',
                ],
                'tabs' => [
                    ['settings_roles', 'filament.admin.resources.settings.roles.index'],
                    ['settings_companies', 'filament.admin.resources.settings.companies.index'],
                    ['settings_teams', 'filament.admin.resources.settings.teams.index'],
                    ['settings_users', 'filament.admin.resources.settings.users.index'],
                    ['custom_fields', 'filament.admin.resources.settings.custom-fields.index'],
                    ['settings_general', 'filament.admin.pages.settings.general'],
                ],
            ],
            'dashboard' => [
                'route_names' => [
                    self::DASHBOARD_ROUTE,
                ],
                'tabs' => [
                    ['dashboard', self::DASHBOARD_ROUTE],
                ],
            ],
        ]);
    }

    public static function activeModuleLabel(): ?string
    {
        return once(function (): ?string {
            $groupKey = self::resolveTabGroupKey();

            if ($groupKey === 'dashboard') {
                return null;
            }

            return match ($groupKey) {
                'employee' => __('filament.navigation.employees'),
                'recruitment' => __('filament.navigation.recruitments'),
                'attendance' => __('filament.navigation.attendance'),
                'time_attendance' => __('filament.navigation.attendance_management'),
                'time_tracker' => __('filament.navigation.time_tracker'),
                'plugins' => __('filament.navigation.plugins'),
                'settings' => __('filament.navigation.settings'),
                default => null,
            };
        });
    }

    private static function resolveTabGroupKey(): string
    {
        $currentPath = self::currentPath();

        foreach (self::tabGroups() as $groupKey => $group) {
            if (self::pathMatchesGroup($currentPath, $group)) {
                return $groupKey;
            }
        }

        return 'dashboard';
    }

    /**
     * @param  array{route_names: list<string>, tabs: list<array{0: string, 1: string}>}  $group
     */
    private static function pathMatchesGroup(string $currentPath, array $group): bool
    {
        foreach ($group['route_names'] as $routeName) {
            if ($routeName === self::DASHBOARD_ROUTE) {
                if (self::isDashboardPath($currentPath)) {
                    return true;
                }

                continue;
            }

            if (self::urlMatches($currentPath, self::routePath($routeName))) {
                return true;
            }
        }

        return false;
    }

    private static function urlMatches(string $currentPath, string $targetPath): bool
    {
        if ($currentPath === $targetPath) {
            return true;
        }

        return str_starts_with($currentPath, rtrim($targetPath, '/').'/');
    }

    /**
     * @return array{label: string, url: string, icon: string|Heroicon, color: string, accent: string}
     */
    private static function moduleItem(
        string $labelKey,
        string $routeName,
        Heroicon $icon,
        string $color,
        string $accent,
    ): array {
        return [
            'label' => __("filament.navigation.{$labelKey}"),
            'url' => self::routeUrl($routeName),
            'icon' => $icon,
            'color' => $color,
            'accent' => $accent,
        ];
    }

    /**
     * @return array{label: string, url: string}
     */
    private static function tabItem(string $labelKey, string $routeName): array
    {
        return [
            'label' => __("filament.navigation.{$labelKey}"),
            'url' => self::routeUrl($routeName),
        ];
    }

    private static function routeUrl(string $routeName): string
    {
        static $urls = [];

        return $urls[$routeName] ??= route($routeName);
    }

    private static function routePath(string $routeName): string
    {
        static $paths = [];

        if (! array_key_exists($routeName, $paths)) {
            $paths[$routeName] = self::urlPath(self::routeUrl($routeName));
        }

        return $paths[$routeName];
    }

    private static function urlPath(string $url): string
    {
        $path = parse_url($url, PHP_URL_PATH);

        return is_string($path) && $path !== '' ? $path : '/';
    }

    private static function currentPath(): string
    {
        return once(fn (): string => self::urlPath(self::currentUrl()));
    }

    private static function currentUrl(): string
    {
        return once(fn (): string => url()->current());
    }

    private static function isDashboardPath(string $currentPath): bool
    {
        return $currentPath === '/admin' || $currentPath === self::routePath(self::DASHBOARD_ROUTE);
    }
}
