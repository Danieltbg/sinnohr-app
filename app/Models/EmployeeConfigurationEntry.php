<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ConfigurationEntryTypeEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeConfigurationEntry extends Model
{
    use SoftDeletes;

    protected $table = 'employee_configuration_entry';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'type',
        'name',
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
            'type' => ConfigurationEntryTypeEnum::class,
            'is_active' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeOfType(Builder $query, ConfigurationEntryTypeEnum $type): Builder
    {
        return $query->where('type', $type->value);
    }
}
