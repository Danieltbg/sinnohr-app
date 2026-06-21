<?php

declare(strict_types=1);

namespace App\Filament\Admin\Navigation;

use App\Enums\ConfigurationEntryTypeEnum;
use Filament\Support\Icons\Heroicon;

final class RecruitmentConfigurationMenu
{
    /**
     * @return list<array{key: string, label: string, route: string, icon: Heroicon}>
     */
    public static function items(): array
    {
        return once(fn (): array => [
            self::item(
                ConfigurationEntryTypeEnum::EmploymentType->menuKey(),
                ConfigurationEntryTypeEnum::EmploymentType->label(),
                'filament.admin.resources.recruitments.configuration.employment-types.index',
                Heroicon::OutlinedBriefcase,
            ),
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
