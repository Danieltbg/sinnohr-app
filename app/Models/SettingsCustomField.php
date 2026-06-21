<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsCustomField extends Model
{
    use SoftDeletes;

    protected $table = 'settings_custom_field';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'model_type',
        'field_type',
        'is_active',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }
}
