<?php

namespace App\Services;

use App\Models\NotificationEvent;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Validation\UnauthorizedException;

class NotificationService
{
    use ResponseTrait;

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

    public function userNotifications()
    {
        try {
            if (! request()->user()) {
                throw new UnauthorizedException('Unauthenticated');
            }

            $notifications = request()->user()->notifications()
                ->orderByDesc('created_at')->get();

            return $this->successResponse(
                data: collect($notifications)->map(function ($data) {
                    return [
                        'data' => $data['data'],
                        'is_read' => $data['read_at'] !== null,
                    ];
                })
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }

    }

    public function setUnreadNotification(int $notifId)
    {
        try {
            $notification = request()->user()->notifications()->whereNull('read_at')->findOrFail($notifId);
            $notification->markAsRead();

            return $this->successResponse();
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function deleteNotification(int $notifId)
    {
        try {
            $notification = request()->user()->notifications()->findOrFail($notifId);
            $notification->delete();

            return $this->successResponse();
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function bulkReadNotification(array $notifIds)
    {
        try {
            $notification = request()->user()->notifications()
                ->whereIn('id', $notifIds)
                ->update(['read_at' => now()]);
            $notification->delete();

            return $this->successResponse();
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function bulkDeleteNotification(array $notifIds)
    {
        try {
            $notification = request()->user()->notifications()
                ->whereIn('id', $notifIds)
                ->delete();
            $notification->delete();

            return $this->successResponse();
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }

    public function notifCount()
    {
        try {
            if (! request()->user()) {
                throw new UnauthorizedException('Unauthenticated');
            }

            $notifications = request()->user()->notifications();
            $unreadCount = $notifications->whereNull('read_at')->count();
            $readCount = $notifications->whereNotNull('read_at')->count();

            return $this->successResponse(
                data: [
                    'read' => $readCount,
                    'unread' => $unreadCount
                ]
            );
        } catch (\Exception $ex) {
            return $this->errorResponse($ex);
        }
    }
}
