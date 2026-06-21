<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivityPlan extends Model
{
    use SoftDeletes;

    protected $table = 'activity_plan';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'master_department_id',
        'manager_id',
        'company_name',
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

    public function department(): BelongsTo
    {
        return $this->belongsTo(MasterDepartment::class, 'master_department_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
