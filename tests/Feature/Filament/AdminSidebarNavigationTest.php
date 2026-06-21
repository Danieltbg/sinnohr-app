<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSidebarNavigationTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_sidebar_menu_pages(): void
    {
        $admin = User::factory()->create([
            'role' => RoleEnum::Admin,
        ]);

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertOk();
        $response->assertSee('Dashboard - PT Pratesis', false);
        $response->assertSee('Employees', false);
        $response->assertSee('Project Management', false);

        $routes = [
            '/admin',
            '/admin/users',
            '/admin/users/create',
            '/admin/employees/departments',
            '/admin/employees/departments/create',
            '/admin/employees/reportings/skills',
            '/admin/employees/configurations/activity-plans',
            '/admin/employees/configurations/departure-reasons',
            '/admin/company-management',
            '/admin/branch',
            '/admin/division',
            '/admin/team',
            '/admin/employee-management',
            '/admin/recruitment',
            '/admin/recruitments/applications/job-positions',
            '/admin/recruitments/applications/applicants',
            '/admin/recruitments/applications/candidates',
            '/admin/recruitments/configuration/employment-types',
            '/admin/shift-management',
            '/admin/attendance-management',
            '/admin/visit-attendance',
            '/admin/attendance',
            '/admin/attendance/my-attendance/dashboard',
            '/admin/attendance/my-attendance/records',
            '/admin/attendance/my-attendance/allocation',
            '/admin/attendance/overview',
            '/admin/attendance/management',
            '/admin/attendance/reporting',
            '/admin/attendance/configuration',
            '/admin/team-meeting',
            '/admin/leave',
            '/admin/plugins',
            '/admin/settings',
            '/admin/settings/roles',
            '/admin/settings/companies',
            '/admin/settings/teams',
            '/admin/settings/users',
            '/admin/settings/custom-fields',
            '/admin/settings/general',
        ];

        foreach ($routes as $route) {
            $this->actingAs($admin)->followingRedirects()->get($route)->assertOk();
        }
    }

    public function test_employee_cannot_open_admin_sidebar_pages(): void
    {
        $employee = User::factory()->create([
            'role' => RoleEnum::User,
        ]);

        $this->actingAs($employee)->get('/admin/branch')->assertForbidden();
    }
}
