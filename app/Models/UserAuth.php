<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAuth extends Model
{
    protected $table = 'user_auth';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'refresh_token',
        'fcm_token',
        'device_metadata',
        'last_login_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'device_metadata' => 'array',
            'last_login_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
