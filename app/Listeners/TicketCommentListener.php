<?php

namespace App\Listeners;

use App\Events\TicketCommentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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

        } catch (\Throwable $th) {
            Log::warning('Error in listener',[
                'error' => $th->getTrace(),
                'message' => $th->getMessage()
            ]);
        }
    }
}
