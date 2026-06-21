<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_employee_receives_forbidden_on_admin_panel(): void
    {
        $employee = User::factory()->create([
            'role' => RoleEnum::User,
        ]);

        $this->actingAs($employee)->get('/admin')->assertForbidden();
    }

    public function test_admin_receives_forbidden_on_portal_panel(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::Admin,
        ]);

        $this->actingAs($admin)->get('/portal')->assertForbidden();
    }

    public function test_admin_can_open_admin_panel(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::Admin,
        ]);

        $this->actingAs($admin)->get('/admin')->assertOk();
    }

    public function test_employee_can_open_portal_panel(): void
    {
        $employee = User::factory()->create([
            'role' => RoleEnum::User,
        ]);

        $this->actingAs($employee)->get('/portal')->assertOk();
    }
}
