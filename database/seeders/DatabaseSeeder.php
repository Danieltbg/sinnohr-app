<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\EmployeeBadgeEnum;
use App\Enums\RoleEnum;
use App\Enums\ConfigurationEntryTypeEnum;
use App\Models\ActivityPlan;
use App\Models\EmployeeConfigurationEntry;
use App\Models\EmployeeSkill;
use App\Models\MasterDepartment;
use App\Models\MasterPosition;
use App\Models\RecruitmentJobPosition;
use App\Models\Role;
use App\Models\SettingsCompany;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private const COMPANY_NAME = 'PT Pratesis';

    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'job_title' => 'HR Manager',
                'phone' => '+62 812 3456 7890',
                'employee_badge' => EmployeeBadgeEnum::Admin,
                'password' => Hash::make('password'),
                'role' => RoleEnum::Admin,
                'is_active' => true,
                'is_deleted' => false,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'employee@example.com'],
            [
                'name' => 'Employee',
                'job_title' => 'Software Engineer',
                'phone' => '+62 812 9876 5432',
                'employee_badge' => EmployeeBadgeEnum::Employee,
                'password' => Hash::make('password'),
                'role' => RoleEnum::User,
                'is_active' => true,
                'is_deleted' => false,
            ],
        );

        $demoEmployees = [
            [
                'name' => 'Aarav Mehta',
                'email' => 'aarav.mehta@example.com',
                'job_title' => 'Software Engineer',
                'phone' => '+62 812 1111 2222',
                'employee_badge' => EmployeeBadgeEnum::Employee,
            ],
            [
                'name' => 'Arjun Malhotra',
                'email' => 'arjun.malhotra@example.com',
                'job_title' => 'Project Lead',
                'phone' => '+62 812 3333 4444',
                'employee_badge' => EmployeeBadgeEnum::Employee,
            ],
            [
                'name' => 'Priya Sharma',
                'email' => 'priya.sharma@example.com',
                'job_title' => 'Learning Specialist',
                'phone' => '+62 812 5555 6666',
                'employee_badge' => EmployeeBadgeEnum::Trainer,
            ],
            [
                'name' => 'Paul Williams',
                'email' => 'paul.williams@example.com',
                'job_title' => 'Administration Manager',
                'phone' => '+62 812 7777 8888',
                'employee_badge' => EmployeeBadgeEnum::Employee,
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@example.com',
                'job_title' => 'Sales Manager',
                'phone' => '+62 812 9999 0000',
                'employee_badge' => EmployeeBadgeEnum::Employee,
            ],
        ];

        $managers = [];

        foreach ($demoEmployees as $employee) {
            $user = User::query()->updateOrCreate(
                ['email' => $employee['email']],
                [
                    'name' => $employee['name'],
                    'job_title' => $employee['job_title'],
                    'phone' => $employee['phone'],
                    'employee_badge' => $employee['employee_badge'],
                    'password' => Hash::make('password'),
                    'role' => RoleEnum::User,
                    'is_active' => true,
                    'is_deleted' => false,
                ],
            );

            $managers[$employee['email']] = $user;
        }

        $departments = [
            [
                'name' => 'Administration',
                'code' => 'ADM',
                'manager_email' => 'paul.williams@example.com',
            ],
            [
                'name' => 'Sales',
                'code' => 'SLS',
                'manager_email' => 'emily.davis@example.com',
            ],
            [
                'name' => 'R&D USA',
                'code' => 'RDUSA',
                'manager_email' => 'arjun.malhotra@example.com',
            ],
            [
                'name' => 'Quality Check Department',
                'code' => 'QC',
                'manager_email' => 'emily.davis@example.com',
            ],
            [
                'name' => 'Engineering',
                'code' => 'ENG',
                'manager_email' => 'aarav.mehta@example.com',
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'manager_email' => 'admin@example.com',
            ],
        ];

        foreach ($departments as $department) {
            MasterDepartment::query()->updateOrCreate(
                ['code' => $department['code']],
                [
                    'name' => $department['name'],
                    'manager_id' => $managers[$department['manager_email']]->id ?? null,
                    'company_name' => self::COMPANY_NAME,
                    'is_deleted' => false,
                ],
            );
        }

        $positions = [
            ['name' => 'Software Engineer', 'code' => 'SE'],
            ['name' => 'HR Manager', 'code' => 'HRM'],
            ['name' => 'Project Lead', 'code' => 'PL'],
            ['name' => 'Learning Specialist', 'code' => 'LS'],
        ];

        foreach ($positions as $position) {
            MasterPosition::query()->updateOrCreate(
                ['code' => $position['code']],
                [
                    'name' => $position['name'],
                    'is_deleted' => false,
                ],
            );
        }

        $arjun = $managers['arjun.malhotra@example.com'] ?? null;

        if ($arjun) {
            $skills = [
                [
                    'skill_name' => 'Agile & Scrum Methodologies',
                    'level' => 'Expert',
                    'proficiency' => 80.00,
                    'skill_type' => 'Quality Analyst',
                ],
                [
                    'skill_name' => 'English',
                    'level' => 'C2',
                    'proficiency' => 100.00,
                    'skill_type' => 'Languages',
                ],
                [
                    'skill_name' => 'Manual Testing',
                    'level' => 'Professional',
                    'proficiency' => 98.00,
                    'skill_type' => 'Quality Analyst',
                ],
            ];

            foreach ($skills as $skill) {
                EmployeeSkill::query()->updateOrCreate(
                    [
                        'user_id' => $arjun->id,
                        'skill_name' => $skill['skill_name'],
                    ],
                    [
                        'level' => $skill['level'],
                        'proficiency' => $skill['proficiency'],
                        'skill_type' => $skill['skill_type'],
                        'is_deleted' => false,
                    ],
                );
            }
        }

        $engineering = MasterDepartment::query()->where('code', 'ENG')->first();
        $hrDept = MasterDepartment::query()->where('code', 'HR')->first();
        $emily = $managers['emily.davis@example.com'] ?? null;
        $paul = $managers['paul.williams@example.com'] ?? null;

        $activityPlans = [
            ['name' => 'Onboarding Checklist', 'department_id' => $hrDept?->id, 'manager_id' => $paul?->id],
            ['name' => 'Quarterly Review', 'department_id' => $engineering?->id, 'manager_id' => $emily?->id],
            ['name' => 'Training Roadmap', 'department_id' => $hrDept?->id, 'manager_id' => $paul?->id],
            ['name' => 'Performance Improvement', 'department_id' => $engineering?->id, 'manager_id' => $emily?->id],
        ];

        foreach ($activityPlans as $plan) {
            ActivityPlan::query()->updateOrCreate(
                ['name' => $plan['name']],
                [
                    'master_department_id' => $plan['department_id'],
                    'manager_id' => $plan['manager_id'],
                    'company_name' => self::COMPANY_NAME,
                    'is_active' => true,
                    'is_deleted' => false,
                ],
            );
        }

        $configurationEntries = [
            [ConfigurationEntryTypeEnum::DepartureReason, 'Resignation'],
            [ConfigurationEntryTypeEnum::DepartureReason, 'Retirement'],
            [ConfigurationEntryTypeEnum::Tag, 'Remote'],
            [ConfigurationEntryTypeEnum::Tag, 'Full-time'],
            [ConfigurationEntryTypeEnum::WorkLocation, 'Head Office'],
            [ConfigurationEntryTypeEnum::WorkLocation, 'Branch Jakarta'],
            [ConfigurationEntryTypeEnum::SkillType, 'Languages'],
            [ConfigurationEntryTypeEnum::SkillType, 'Quality Analyst'],
            [ConfigurationEntryTypeEnum::EmploymentType, 'Permanent'],
            [ConfigurationEntryTypeEnum::EmploymentType, 'Contract'],
            [ConfigurationEntryTypeEnum::JobPosition, 'Software Engineer'],
            [ConfigurationEntryTypeEnum::JobPosition, 'HR Manager'],
        ];

        foreach ($configurationEntries as [$type, $name]) {
            EmployeeConfigurationEntry::query()->updateOrCreate(
                [
                    'type' => $type,
                    'name' => $name,
                ],
                [
                    'is_active' => true,
                    'is_deleted' => false,
                ],
            );
        }

        $jobPositions = [
            [
                'name' => 'Software Engineer',
                'manager_id' => $paul?->id,
                'master_department_id' => $engineering?->id,
                'company_name' => 'BlueOcean Technologies Inc.',
                'new_applications_count' => 0,
            ],
            [
                'name' => 'HR Manager',
                'manager_id' => $paul?->id,
                'master_department_id' => $hrDept?->id,
                'company_name' => 'BlueOcean Technologies Inc.',
                'new_applications_count' => 0,
            ],
            [
                'name' => 'Marketing Specialist',
                'manager_id' => $paul?->id,
                'master_department_id' => $hrDept?->id,
                'company_name' => 'BlueOcean Technologies Inc.',
                'new_applications_count' => 0,
            ],
        ];

        foreach ($jobPositions as $position) {
            RecruitmentJobPosition::query()->updateOrCreate(
                ['name' => $position['name']],
                [
                    'manager_id' => $position['manager_id'],
                    'master_department_id' => $position['master_department_id'],
                    'company_name' => $position['company_name'],
                    'new_applications_count' => $position['new_applications_count'],
                    'is_active' => true,
                    'is_deleted' => false,
                ],
            );
        }

        $settingsRoles = [
            ['name' => 'Admin', 'slug' => 'admin', 'permissions_count' => 2658],
            ['name' => 'Sales Admin', 'slug' => 'sales-admin', 'permissions_count' => 0],
            ['name' => 'Hr Admin', 'slug' => 'hr-admin', 'permissions_count' => 84],
        ];

        foreach ($settingsRoles as $settingsRole) {
            Role::query()->updateOrCreate(
                ['slug' => $settingsRole['slug']],
                [
                    'name' => $settingsRole['name'],
                    'guard_name' => 'web',
                    'permissions_count' => $settingsRole['permissions_count'],
                    'is_deleted' => false,
                ],
            );
        }

        SettingsCompany::query()->updateOrCreate(
            ['code' => 'PRATESIS'],
            [
                'name' => 'PT Pratesis',
                'is_active' => true,
                'is_deleted' => false,
            ],
        );
    }
}
