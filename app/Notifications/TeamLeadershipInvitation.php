<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\Team;
use Filament\Actions\Action;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TeamLeadershipInvitation extends Notification
{
    use Queueable;

    public function __construct(
        public Team $team,
        public string $responseType = 'invitation'
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return FilamentNotification::make()
            ->title('Team Leadership Invitation')
            ->body('You have been invited to lead the team: '.$this->team->name.'. Do you accept?')
            ->persistent()
            ->viewData(['team_id' => $this->team->id])
            ->actions([
                Action::make('accept')
                    ->label('Accept')
                    ->button()
                    ->color('success')
                    ->markAsRead()
                    ->dispatch('leadership-response', [
                        'team_id' => $this->team->id,
                        'response' => 'accept',
                    ]),
                Action::make('reject')
                    ->label('Reject')
                    ->button()
                    ->color('danger')
                    ->markAsRead()
                    ->dispatch('leadership-response', [
                        'team_id' => $this->team->id,
                        'response' => 'reject',
                    ]),
            ])
            ->getDatabaseMessage();
    }
}
