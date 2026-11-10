<?php

namespace App\Notifications;

use App\Models\Ticket;
use App\Models\User;
use App\Traits\NotificationFormatTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OwnerTicketAssigneeNotification extends Notification
{
    use NotificationFormatTrait, Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public Ticket $ticket,
        public User $user
    ) {}

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Ticket Assigned')
            ->view('mail.new-ticket',
                [
                    'ticket' => $this->ticket,
                    'user' => $this->user,
                    'ticketUrl' => '',
                ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->notificationFormat(
            id: $this->ticket?->id,
            title: 'New Ticket Assigned',
            message: 'A new ticket has been assigned to you. Please review the details and take the necessary action.',
            type : 'ticket.assigned'
        );
    }
}
