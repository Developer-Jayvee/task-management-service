<?php

namespace App\Listeners;

use App\Events\TicketUpdateNotification;
use App\Jobs\ProcessNotificationJob;
use App\Models\NotificationEvent;
use App\Notifications\OwnerTicketNotification;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SendTicketNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(TicketUpdateNotification $event): void
    {
        try {
            $ticket = $event->ticket;
            $user = $event->user;
    
            $owner = $user->getTenant()?->owner->user;
            Notification::send($owner,new OwnerTicketNotification(
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
