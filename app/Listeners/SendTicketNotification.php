<?php

namespace App\Listeners;

use App\Events\TicketUpdateNotification;
use App\Jobs\ProcessNotificationJob;
use App\Models\NotificationEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(
        private readonly NotificationService $notifService
    ) {}

    /**
     * Handle the event.
     */
    public function handle(TicketUpdateNotification $event): void
    {
        $ticket = $event->ticket;
        $type = $event->type;
        $user = $event->user;

        // if($ticket->status === 'completed') {
            $data = $this->notifService->createNotif(
                user: $user,
                type : $type,
                data : ['ticket_id' => $ticket->id]
            );
            // ProcessNotificationJob::dispatch($data);
        // }
    }
}
