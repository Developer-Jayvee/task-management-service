<?php

namespace App\Services;

use App\Models\NotificationEvent;
use App\Models\User;

class NotificationService
{
    const PENDING = 'pending';

    const PROCESSING = 'processing';

    const FAILED = 'failed';

    const COMPLETED = 'completed';

    public function __construct(
        public ?NotificationEvent $notif = null
    ) {}

    public static function createNotif(User $user, string $type, array $data)
    {
        $tenant = $user->getTenant();

        return NotificationEvent::query()->create([
            'tenant_id' => $tenant?->id,
            'user_id' => $user->id,
            'type' => $type,
            'status' => self::PENDING,
            'data' => $data,
        ]);
    }

    public function process()
    {
        if (! $this->notif) {
            return null;
        }

        return $this->notif->update([
            'status' => self::PROCESSING,
        ]);
    }

    public function failed()
    {
        if (! $this->notif) {
            return null;
        }

        return $this->notif->update([
            'status' => self::FAILED,
        ]);
    }

    public function send(User $user, mixed $notif)
    {
        if (! $this->notif) {
            return null;
        }

        $user->notify($notif);

        return $this->notif->update([
            'status' => self::COMPLETED,
        ]);
    }
}
