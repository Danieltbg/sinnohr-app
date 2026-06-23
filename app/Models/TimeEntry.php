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
        'approval_status',
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
            'approval_status' => 'string',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (self $entry) {
            if (
                $entry->is_overtime
                && ! in_array($entry->approval_status, ['approved', 'rejected'], true)
            ) {
                $entry->approval_status = 'pending';
            }
        });
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
