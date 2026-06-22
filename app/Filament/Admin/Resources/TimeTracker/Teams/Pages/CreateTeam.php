<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Pages;

use App\Filament\Admin\Resources\TimeTracker\Teams\TeamResource;
use App\Models\User;
use App\Notifications\TeamAssignmentNotification;
use App\Notifications\TeamLeadershipInvitation;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;

    protected function afterCreate(): void
    {
        $team = $this->record;
        $team->load(['leader', 'members']);

        $leader = $team->leader;

        if ($leader !== null) {
            NotificationFacade::sendNow($leader, new TeamLeadershipInvitation($team));
        }

        $memberIds = collect($team->members->pluck('id'))
            ->merge(data_get($this->data, 'members', []))
            ->filter()
            ->unique()
            ->values();

        $leaderName = $leader?->name ?? 'Unknown';
        $members = User::whereIn('id', $memberIds)->get();

        if ($members->isNotEmpty()) {
            NotificationFacade::sendNow($members, new TeamAssignmentNotification($team, $leaderName));

            foreach ($members as $member) {
                DatabaseNotificationsSent::dispatch($member);
            }
        }
    }
}
