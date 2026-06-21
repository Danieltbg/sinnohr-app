<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentJobPosition extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_job_position';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'manager_id',
        'master_department_id',
        'company_name',
        'new_applications_count',
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
            'new_applications_count' => 'integer',
            'is_active' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(MasterDepartment::class, 'master_department_id');
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(RecruitmentApplicant::class);
    }
}
