<?php

declare(strict_types=1);

namespace App\Enums;

enum EmployeeBadgeEnum: string
{
    case Employee = 'employee';
    case Admin = 'admin';
    case Trainer = 'trainer';

    public function label(): string
    {
        return match ($this) {
            self::Employee => __('filament.employees.badges.employee'),
            self::Admin => __('filament.employees.badges.admin'),
            self::Trainer => __('filament.employees.badges.trainer'),
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Employee => 'employee',
            self::Admin => 'admin',
            self::Trainer => 'trainer',
        };
    }
}
