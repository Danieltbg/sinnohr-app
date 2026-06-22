<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Pages;

use App\Filament\Admin\Resources\TimeTracker\Teams\TeamResource;
use App\Models\User;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

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

        $leader = $team->leader;
        $members = $team->members;

        if ($leader !== null) {
            Notification::make()
                ->title('Team Leadership')
                ->body('You have been assigned as the leader of team: '.$team->name)
                ->sendToDatabase($leader);
        }

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
                ->sendToDatabase($member);
        }
    }
}
