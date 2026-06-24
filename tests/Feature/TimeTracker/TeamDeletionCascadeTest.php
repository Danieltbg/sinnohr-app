<?php

declare(strict_types=1);

namespace Tests\Feature\TimeTracker;

use App\Models\Project;
use App\Models\Team;
use App\Models\TimeEntry;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamDeletionCascadeTest extends TestCase
{
    use RefreshDatabase;

    public function test_deleting_team_removes_projects_memberships_and_project_time_entries(): void
    {
        $leader = User::factory()->create();
        $member = User::factory()->create();

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

        $projectEntry = TimeEntry::create([
            'user_id' => $member->id,
            'project_id' => $project->id,
            'description' => 'Deployment support',
            'start_time' => now()->subHours(2),
            'end_time' => now(),
            'duration' => 7200,
            'is_billable' => false,
            'date' => today(),
        ]);

        $personalEntry = TimeEntry::create([
            'user_id' => $member->id,
            'project_id' => null,
            'description' => 'Personal activity',
            'start_time' => now()->subHour(),
            'end_time' => now(),
            'duration' => 3600,
            'is_billable' => false,
            'date' => today(),
        ]);

        $team->delete();

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
        $this->assertDatabaseMissing('team_user', [
            'team_id' => $team->id,
            'user_id' => $member->id,
        ]);
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        $this->assertDatabaseMissing('time_entries', ['id' => $projectEntry->id]);
        $this->assertDatabaseHas('time_entries', ['id' => $personalEntry->id]);
    }
}
