<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\Team;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class TeamInvitationHandler extends Component
{
    #[On('leadership-response')]
    public function handleLeadershipResponse(int|string|null $team_id = null, ?string $response = null): void
    {
        $user = Auth::user();

        if ($team_id === null || $response === null || $user === null) {
            return;
        }

        $team = Team::find($team_id);

        if ($team === null || $team->leader_id !== $user->id) {
            return;
        }

        if ($response === 'accept') {
            $team->update(['leader_status' => 'accepted']);

            Notification::make()
                ->title('Leadership Accepted')
                ->body('You can now monitor activity for team: '.$team->name)
                ->success()
                ->send();
        } elseif ($response === 'reject') {
            $team->update(['leader_status' => 'rejected']);

            Notification::make()
                ->title('Leadership Rejected')
                ->body('You rejected the leadership invitation for team: '.$team->name)
                ->warning()
                ->send();
        }

        foreach ($user->unreadNotifications as $notification) {
            $notificationTeamId = data_get($notification->data, 'viewData.team_id')
                ?? data_get($notification->data, 'actions.0.eventData.team_id');

            if ((string) $notificationTeamId === (string) $team->id) {
                $notification->markAsRead();
            }
        }
    }

    public function render(): string
    {
        return '<div></div>';
    }
}
