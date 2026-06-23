<?php

declare(strict_types=1);

namespace App\Notifications;

use App\Models\TimeEntry;
use Filament\Notifications\Notification as FilamentNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class OvertimeApprovalStatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        public TimeEntry $timeEntry,
        public string $status,
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        $approved = $this->status === 'approved';
        $projectName = $this->timeEntry->project?->name ?? 'No Project';

        $notification = FilamentNotification::make()
            ->title($approved ? 'Overtime Approved' : 'Overtime Rejected')
            ->body("Your overtime entry for {$projectName} has been {$this->status}.");

        if ($approved) {
            $notification->success();
        } else {
            $notification->danger();
        }

        return $notification->getDatabaseMessage();
    }
}
