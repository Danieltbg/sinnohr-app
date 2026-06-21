<?php

declare(strict_types=1);

namespace App\Enums;

enum ConfigurationEntryTypeEnum: string
{
    case DepartureReason = 'departure_reason';
    case Tag = 'tag';
    case WorkLocation = 'work_location';
    case SkillType = 'skill_type';
    case EmploymentType = 'employment_type';
    case JobPosition = 'job_position';

    public function label(): string
    {
        return match ($this) {
            self::DepartureReason => __('filament.employees.configurations.menu.departure_reasons'),
            self::Tag => __('filament.employees.configurations.menu.tags'),
            self::WorkLocation => __('filament.employees.configurations.menu.work_locations'),
            self::SkillType => __('filament.employees.configurations.menu.skill_types'),
            self::EmploymentType => __('filament.employees.configurations.menu.employment_types'),
            self::JobPosition => __('filament.employees.configurations.menu.job_positions'),
        };
    }

    public function menuKey(): string
    {
        return $this->value;
    }
}
