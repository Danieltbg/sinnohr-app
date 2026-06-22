<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Role extends Model
{
    use SoftDeletes;

    protected $table = 'role';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'guard_name',
        'description',
        'permissions_count',
        'permissions',
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
            'permissions' => 'array',
            'permissions_count' => 'integer',
            'is_deleted' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (Role $role): void {
            if (blank($role->slug) && filled($role->name)) {
                $role->slug = Str::slug($role->name);
            }

            if (blank($role->guard_name)) {
                $role->guard_name = 'web';
            }

            if (is_array($role->permissions)) {
                $role->permissions_count = count($role->permissions);
            }
        });
    }
}
