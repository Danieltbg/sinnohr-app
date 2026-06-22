<?php

declare(strict_types=1);

namespace App\Livewire\Notifications;

use App\Models\Team;
use Filament\Livewire\DatabaseNotifications;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class LeadershipInvitationListener extends DatabaseNotifications
{
    #[On('leadership-response')]
    public function handleLeadershipResponse(int|string|null $team_id = null, ?string $response = null): void
    {
        $user = Auth::user();

        if ($team_id === null || $response === null || $user === null) {
            return;
        }

        $team = Team::find($team_id);

        if ($team === null) {
            return;
        }

        if ($team->leader_id !== $user->id) {
            return;
        }

        if ($response === 'accept') {
            $team->update(['leader_status' => 'accepted']);

            Notification::make()
                ->title('Leadership Accepted')
                ->body('You have accepted the leadership of team: '.$team->name)
                ->success()
                ->sendToDatabase($user, isEventDispatched: true);
        } elseif ($response === 'reject') {
            $team->update(['leader_status' => 'rejected']);

            Notification::make()
                ->title('Leadership Rejected')
                ->body('You have rejected the leadership of team: '.$team->name)
                ->warning()
                ->sendToDatabase($user, isEventDispatched: true);
        }

        foreach ($user->unreadNotifications as $notification) {
            $data = $notification->data;
            $notificationTeamId = data_get($data, 'viewData.team_id')
                ?? data_get($data, 'actions.0.eventData.team_id');

            if ((string) $notificationTeamId !== (string) $team->id) {
                continue;
            }

            $notification->markAsRead();
        }

        $this->refresh();
    }
}
