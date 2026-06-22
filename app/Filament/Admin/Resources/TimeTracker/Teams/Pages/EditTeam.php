<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Pages;

use App\Filament\Admin\Resources\TimeTracker\Teams\TeamResource;
use App\Models\Team;
use App\Models\User;
use App\Notifications\TeamLeadershipInvitation;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class EditTeam extends EditRecord
{
    protected static string $resource = TeamResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function afterSave(): void
    {
        $team = $this->record;
        $team->load(['leader', 'members']);

        $this->handleLeaderChange($team);
        $this->sendMemberNotifications($team);
    }

    private function handleLeaderChange(Team $team): void
    {
        $leader = $team->leader;

        if ($leader === null) {
            return;
        }

        if ($team->wasChanged('leader_id') || $team->leader_status === 'pending') {
            $team->update(['leader_status' => 'pending']);

            NotificationFacade::sendNow($leader, new TeamLeadershipInvitation($team));
        }
    }

    private function sendMemberNotifications(Team $team): void
    {
        $leader = $team->leader;
        $members = $team->members;

        $memberIds = $members->pluck('id')->toArray();
        $leaderId = $leader?->id;

        if ($leaderId !== null) {
            $memberIds = array_diff($memberIds, [$leaderId]);
        }

        $memberUsers = User::whereIn('id', $memberIds)->get();

        $leaderName = $leader?->name ?? 'Unknown';

        foreach ($memberUsers as $member) {
            Notification::make()
                ->title('Team Assignment')
                ->body('You have been added to team '.$team->name.' led by '.$leaderName)
                ->sendToDatabase($member, isEventDispatched: true);
        }
    }
}
