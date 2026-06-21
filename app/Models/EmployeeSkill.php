<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSkill extends Model
{
    use SoftDeletes;

    protected $table = 'employee_skill';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'skill_name',
        'level',
        'proficiency',
        'skill_type',
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
            'proficiency' => 'decimal:2',
            'is_deleted' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
