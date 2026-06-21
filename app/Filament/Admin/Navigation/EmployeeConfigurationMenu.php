<?php

declare(strict_types=1);

namespace App\Filament\Admin\Navigation;

use App\Enums\ConfigurationEntryTypeEnum;
use Filament\Support\Icons\Heroicon;

final class EmployeeConfigurationMenu
{
    /**
     * @return list<array{key: string, label: string, items: list<array{key: string, label: string, route: string, icon: Heroicon}>}>
     */
    public static function sections(): array
    {
        return once(fn (): array => [
            [
                'key' => 'employee',
                'label' => __('filament.employees.configurations.sections.employee'),
                'items' => [
                    self::item('activity_plans', __('filament.employees.configurations.menu.activity_plans'), 'filament.admin.resources.employees.configurations.activity-plans.index', Heroicon::OutlinedClipboardDocumentList),
                    self::item(ConfigurationEntryTypeEnum::DepartureReason->menuKey(), ConfigurationEntryTypeEnum::DepartureReason->label(), 'filament.admin.resources.employees.configurations.departure-reasons.index', Heroicon::OutlinedArrowRightOnRectangle),
                    self::item(ConfigurationEntryTypeEnum::Tag->menuKey(), ConfigurationEntryTypeEnum::Tag->label(), 'filament.admin.resources.employees.configurations.tags.index', Heroicon::OutlinedTag),
                    self::item(ConfigurationEntryTypeEnum::WorkLocation->menuKey(), ConfigurationEntryTypeEnum::WorkLocation->label(), 'filament.admin.resources.employees.configurations.work-locations.index', Heroicon::OutlinedMapPin),
                    self::item(ConfigurationEntryTypeEnum::SkillType->menuKey(), ConfigurationEntryTypeEnum::SkillType->label(), 'filament.admin.resources.employees.configurations.skill-types.index', Heroicon::OutlinedAcademicCap),
                ],
            ],
            [
                'key' => 'recruitment',
                'label' => __('filament.employees.configurations.sections.recruitment'),
                'items' => [
                    self::item(ConfigurationEntryTypeEnum::EmploymentType->menuKey(), ConfigurationEntryTypeEnum::EmploymentType->label(), 'filament.admin.resources.employees.configurations.employment-types.index', Heroicon::OutlinedBriefcase),
                    self::item(ConfigurationEntryTypeEnum::JobPosition->menuKey(), ConfigurationEntryTypeEnum::JobPosition->label(), 'filament.admin.resources.employees.configurations.job-positions.index', Heroicon::OutlinedUserCircle),
                ],
            ],
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
