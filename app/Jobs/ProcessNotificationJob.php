<?php

namespace App\Jobs;

use App\Models\NotificationEvent;
use App\Services\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Foundation\Queue\Queueable;
use DB;


class ProcessNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public NotificationEvent $notif,
    ){}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $service = new NotificationService($this->notif);
        var_dump($service->notif);
        try {
            
            // $service->send();
        } catch (\Throwable $th) {
            // $service->failed();
            throw $th;
        } 
    }
}
