<?php

namespace App\Listeners;

use App\Events\TicketCommentEvent;
use App\Notifications\TicketCommentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Laravel\Reverb\Loggers\Log;

class TicketCommentListener implements ShouldQueue
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
    public function handle(TicketCommentEvent $event): void
    {
        try {
            $ticket = $event->ticket;
            $user = $event->user;
            $owner = $user->getTenant()?->owner->user;
            
            Notification::send($owner, new TicketCommentNotification(
                $ticket,
                $user
            ));
        } catch (\Throwable $th) {
            Log::warning('Error in listener',[
                'error' => $th->getTrace(),
                'message' => $th->getMessage()
            ]);
        }
    }
}
