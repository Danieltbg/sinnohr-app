<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterDepartment extends Model
{
    use SoftDeletes;

    protected $table = 'master_department';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
        'manager_id',
        'company_name',
        'parent_id',
        'color',
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
            'is_deleted' => 'boolean',
        ];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->manager) {
            return $this->manager->avatar_url;
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=random&size=128';
    }
}
