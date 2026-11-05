<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use App\Traits\NotificationFormatTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TicketCommentNotification extends Notification
{
    use Queueable, NotificationFormatTrait;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Ticket $ticket,
        public User $user
    )
    {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database','broadcast'];
    }

    /**

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->notificationFormat(
            id: $this->ticket?->id,
            title: 'New Comment',
            message: "{$this->user->name} commented on Ticket# {$this->ticket?->id}",
            type : "ticket.comment"
        );
    }
}
