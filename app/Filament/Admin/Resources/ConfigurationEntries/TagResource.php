<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\ConfigurationEntries;

use App\Enums\ConfigurationEntryTypeEnum;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\CreateTag;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\EditTag;
use App\Filament\Admin\Resources\ConfigurationEntries\Pages\ListTags;
use Filament\Support\Icons\Heroicon;

class TagResource extends BaseConfigurationEntryResource
{
    protected static ?string $slug = 'employees/configurations/tags';

    protected static string|null|\BackedEnum $navigationIcon = Heroicon::OutlinedTag;

    public static function entryType(): ConfigurationEntryTypeEnum
    {
        return ConfigurationEntryTypeEnum::Tag;
    }

    public static function configurationMenuKey(): string
    {
        return ConfigurationEntryTypeEnum::Tag->menuKey();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTags::route('/'),
            'create' => CreateTag::route('/create'),
            'edit' => EditTag::route('/{record}/edit'),
        ];
    }
}
