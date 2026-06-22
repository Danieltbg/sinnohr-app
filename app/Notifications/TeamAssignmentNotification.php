<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Team;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeamAssignmentNotification extends Notification
{
    use Queueable;

    public function __construct(
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
            ->title('Team Assignment')
            ->body("You have been added to Team: {$this->team->name}. Your Team Leader is: {$this->leaderName}.")
            ->info()
            ->getDatabaseMessage();
    }
}
