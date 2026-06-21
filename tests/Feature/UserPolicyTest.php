<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class UserPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admin_can_view_any_users(): void
    {
        $admin = User::factory()->create(['role' => RoleEnum::Admin]);
        $employee = User::factory()->create(['role' => RoleEnum::User]);

        $this->assertTrue(Gate::forUser($admin)->allows('viewAny', User::class));
        $this->assertFalse(Gate::forUser($employee)->allows('viewAny', User::class));
    }

    public function test_employee_can_view_own_user_record(): void
    {
        $employee = User::factory()->create(['role' => RoleEnum::User]);

        $this->assertTrue(Gate::forUser($employee)->allows('view', $employee));
    }

    public function test_employee_cannot_view_other_user_record(): void
    {
        $employee = User::factory()->create(['role' => RoleEnum::User]);
        $other = User::factory()->create(['role' => RoleEnum::User]);

        $this->assertFalse(Gate::forUser($employee)->allows('view', $other));
    }
}
