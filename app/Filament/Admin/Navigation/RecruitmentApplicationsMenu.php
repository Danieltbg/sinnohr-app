<?php

declare(strict_types=1);

namespace App\Filament\Admin\Navigation;

use Filament\Support\Icons\Heroicon;

final class RecruitmentApplicationsMenu
{
    /**
     * @return list<array{key: string, label: string, route: string, icon: Heroicon}>
     */
    public static function items(): array
    {
        return once(fn (): array => [
            self::item('job_positions', __('filament.recruitments.applications.menu.job_positions'), 'filament.admin.resources.recruitments.applications.job-positions.index', Heroicon::OutlinedBriefcase),
            self::item('applicants', __('filament.recruitments.applications.menu.applicants'), 'filament.admin.resources.recruitments.applications.applicants.index', Heroicon::OutlinedUserGroup),
            self::item('candidates', __('filament.recruitments.applications.menu.candidates'), 'filament.admin.resources.recruitments.applications.candidates.index', Heroicon::OutlinedUser),
        ]);
    }

    /**
     * @return array{key: string, label: string, route: string, icon: Heroicon}
     */
    private static function item(string $key, string $label, string $route, Heroicon $icon): array
    {
        return [
            'key' => $key,
            'label' => $label,
            'route' => $route,
            'icon' => $icon,
        ];
    }
}
