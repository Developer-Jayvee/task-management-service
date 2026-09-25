<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function updateStatus(User $user, Ticket $ticket)
    {
        return $user->can('ticket update-status') && $user->id === $ticket->assignee_id;
    }
    public function update(User $user, Ticket $ticket)
    {
        return $user->can('ticket update');
    } 
    public function delete(User $user, Ticket $ticket)
    {
        return $user->can('ticket delete');
    }
    public function create(User $user)
    {
        return $user->can('ticket create');
    }
    public function view(User $user, Ticket $ticket)
    {
        return $user->can('ticket view');
    }
}
