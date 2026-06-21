<?php

declare(strict_types=1);

namespace App\Filament\Admin\Pages;

use App\Filament\Admin\Concerns\RegistersAdminNavigation;
use Filament\Pages\Page;

abstract class BaseAdminPage extends Page
{
    use RegistersAdminNavigation;

    protected string $view = 'filament.admin.pages.placeholder';

    protected static ?string $title = null;

    public function getTitle(): string
    {
        return static::$title ?? (string) str(class_basename(static::class))
            ->headline()
            ->toString();
    }
}
