<?php

declare(strict_types=1);

namespace App\Filament\Admin\Resources\TimeTracker\Teams\Pages;

use App\Filament\Admin\Resources\TimeTracker\Teams\TeamResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTeam extends CreateRecord
{
    protected static string $resource = TeamResource::class;

    protected function afterCreate(): void
    {
        $team = $this->record;

        $recipients = collect([$team->leader_id])
            ->merge($team->members->pluck('id'))
            ->unique()
            ->filter();

        foreach ($recipients as $recipientId) {
            $user = User::find($recipientId);

            if ($user === null) {
                continue;
            }

            Notification::make()
                ->title('You have been assigned to Team: '.$team->name)
                ->body('Check your new project assignment details now.')
                ->sendToDatabase($user);
        }
    }
}
