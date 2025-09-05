<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        // user sadece kendi ticketlarını görsün, agent/admin tümünü
        return true;
    }

    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin') || $user->hasRole('agent')) {
            return true; // admin & agent tüm ticketları görür
        }

        return $ticket->created_by_user_id === $user->id; // user sadece kendi ticketını görür
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['user', 'agent', 'admin']);
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin') || $user->hasRole('agent');
    }

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }
}
