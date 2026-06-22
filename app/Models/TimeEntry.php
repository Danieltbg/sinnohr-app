<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimeEntry extends Model
{
    protected $fillable = [
        'user_id',
        'description',
        'project_id',
        'start_time',
        'end_time',
        'duration',
        'is_billable',
        'is_overtime',
        'tags',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'duration' => 'integer',
            'is_billable' => 'boolean',
            'is_overtime' => 'boolean',
            'date' => 'date',
            'tags' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->withDefault([
            'name' => 'No Project',
        ]);
    }
}
