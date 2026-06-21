<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecruitmentApplicant extends Model
{
    use SoftDeletes;

    protected $table = 'recruitment_applicant';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'recruitment_job_position_id',
        'name',
        'email',
        'status',
        'is_active',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function jobPosition(): BelongsTo
    {
        return $this->belongsTo(RecruitmentJobPosition::class, 'recruitment_job_position_id');
    }
}
