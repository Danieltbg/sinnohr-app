<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterPosition extends Model
{
    use SoftDeletes;

    protected $table = 'master_position';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'code',
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
}
