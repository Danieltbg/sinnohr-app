<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingsCompany extends Model
{
    use SoftDeletes;

    protected $table = 'settings_company';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
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
