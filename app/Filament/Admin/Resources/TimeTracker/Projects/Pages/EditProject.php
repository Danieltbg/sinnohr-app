<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Projects\Pages;

use App\Filament\Admin\Resources\TimeTracker\Projects\ProjectResource;
use App\Models\User;
use App\Notifications\ProjectTeamAssignmentNotification;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function afterSave(): void
    {
        $project = $this->record;

        if (! $project->wasChanged('team_id')) {
            return;
        }

        $project->load(['team.leader', 'team.members']);

        $team = $project->team;

        if ($team === null) {
            return;
        }

        $leader = $team->leader;
        $leaderName = $leader?->name ?? 'Unknown';

        $recipientIds = collect($team->members->pluck('id'))
            ->when($leader !== null, fn ($ids) => $ids->push($leader->id))
            ->filter()
            ->unique()
            ->values();

        $recipients = User::whereIn('id', $recipientIds)->get();

        if ($recipients->isEmpty()) {
            return;
        }

        NotificationFacade::sendNow(
            $recipients,
            new ProjectTeamAssignmentNotification($project, $team, $leaderName),
        );

        foreach ($recipients as $recipient) {
            DatabaseNotificationsSent::dispatch($recipient);
        }
    }
}
