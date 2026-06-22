<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Project;
use App\Models\Team;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ProjectTeamAssignmentNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Project $project,
        public Team $team,
        public string $leaderName,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title('Project Assignment')
            ->body("Your team has been assigned to Project: {$this->project->name}. Team: {$this->team->name}. Team Leader: {$this->leaderName}.")
            ->success()
            ->getDatabaseMessage();
    }
}
