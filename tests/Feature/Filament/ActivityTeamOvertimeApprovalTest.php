<?php

declare(strict_types=1);

namespace Tests\Feature\Filament;

use App\Enums\RoleEnum;
use App\Filament\Admin\Pages\TimeTracker\ActivityTeam;
use App\Models\Project;
use App\Models\Team;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityTeamOvertimeApprovalTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_non_leader_cannot_approve_own_overtime(): void
    {
        $admin = User::factory()->create(['role' => RoleEnum::Admin]);
        $leader = User::factory()->create(['role' => RoleEnum::User]);

        $team = Team::create([
            'name' => 'Implementation Team',
            'leader_id' => $leader->id,
            'leader_status' => 'accepted',
        ]);
        $team->members()->attach($admin->id);

        $project = Project::create([
            'name' => 'HRIS Rollout',
            'client_name' => 'Internal',
            'team_id' => $team->id,
        ]);

        $entry = TimeEntry::create([
            'user_id' => $admin->id,
            'project_id' => $project->id,
            'description' => 'Deployment support',
            'start_time' => now()->subHours(2),
            'end_time' => now(),
            'duration' => 7200,
            'is_billable' => false,
            'is_overtime' => true,
            'date' => today(),
            'approval_status' => 'pending',
        ]);

        $this->actingAs($admin);

        (new ActivityTeam)->approveOvertime($entry->id);

        $this->assertSame('pending', $entry->refresh()->approval_status);
    }

    public function test_accepted_team_leader_can_approve_member_overtime(): void
    {
        $leader = User::factory()->create(['role' => RoleEnum::User]);
        $member = User::factory()->create(['role' => RoleEnum::User]);

        $team = Team::create([
            'name' => 'Implementation Team',
            'leader_id' => $leader->id,
            'leader_status' => 'accepted',
        ]);
        $team->members()->attach($member->id);

        $project = Project::create([
            'name' => 'HRIS Rollout',
            'client_name' => 'Internal',
            'team_id' => $team->id,
        ]);

        $entry = TimeEntry::create([
            'user_id' => $member->id,
            'project_id' => $project->id,
            'description' => 'Deployment support',
            'start_time' => now()->subHours(2),
            'end_time' => now(),
            'duration' => 7200,
            'is_billable' => false,
            'is_overtime' => true,
            'date' => today(),
            'approval_status' => 'pending',
        ]);

        $this->actingAs($leader);

        (new ActivityTeam)->approveOvertime($entry->id);

        $this->assertSame('approved', $entry->refresh()->approval_status);
    }
}
