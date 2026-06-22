<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EmployeeBadgeEnum;
use App\Enums\RoleEnum;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasApiTokens;

    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    protected $table = 'user';

    /**
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'job_title',
        'phone',
        'work_phone',
        'employee_badge',
        'employee_tags',
        'profile_photo_path',
        'master_department_id',
        'master_position_id',
        'manager_id',
        'coach_id',
        'work_address',
        'work_location',
        'time_off_approver_id',
        'attendance_manager_id',
        'working_hours',
        'timezone',
        'company_name',
        'department_note',
        'private_email',
        'private_phone',
        'home_address',
        'birth_date',
        'gender',
        'password',
        'role',
        'is_active',
        'created_by',
        'updated_by',
        'is_deleted',
    ];

    /**
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => RoleEnum::class,
            'employee_badge' => EmployeeBadgeEnum::class,
            'employee_tags' => 'array',
            'birth_date' => 'date',
            'is_active' => 'boolean',
            'is_deleted' => 'boolean',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return match ($panel->getId()) {
            'admin' => $this->isAdmin() || $this->hasAcceptedTeamLeadership(),
            'portal' => $this->role === RoleEnum::User,
            default => false,
        };
    }

    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::Admin;
    }

    public function isUser(): bool
    {
        return $this->role === RoleEnum::User;
    }

    public function hasAcceptedTeamLeadership(): bool
    {
        return Team::where('leader_id', $this->id)
            ->where('leader_status', 'accepted')
            ->exists();
    }

    public function userAuth(): HasOne
    {
        return $this->hasOne(UserAuth::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(MasterDepartment::class, 'master_department_id');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(MasterPosition::class, 'master_position_id');
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'manager_id');
    }

    public function coach(): BelongsTo
    {
        return $this->belongsTo(self::class, 'coach_id');
    }

    public function timeOffApprover(): BelongsTo
    {
        return $this->belongsTo(self::class, 'time_off_approver_id');
    }

    public function attendanceManager(): BelongsTo
    {
        return $this->belongsTo(self::class, 'attendance_manager_id');
    }

    public function getAvatarUrlAttribute(): string
    {
        if (filled($this->profile_photo_path)) {
            return Storage::disk('public')->url($this->profile_photo_path);
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=random&size=128';
    }
}
