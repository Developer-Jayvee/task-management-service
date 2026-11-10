<?php

namespace App\Listeners;

use App\Events\TicketAssigneeEvent;
use App\Notifications\OwnerTicketAssigneeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendTicketAssigneeNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TicketAssigneeEvent $event): void
    {
        try {
            $ticket = $event->ticket;
            $user = $event->user;

            Notification::send($ticket?->assignee?->id,
                new OwnerTicketAssigneeNotification(
                    ticket: $ticket,
                    user: $user
                )
            );
        } catch (\Throwable $th) {
            // throw $th;
        }
    }
}
