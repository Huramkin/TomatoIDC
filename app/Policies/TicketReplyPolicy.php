<?php

namespace App\Policies;

use App\Ticket;
use App\User;
use App\TicketReply;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticket reply.
     *
     * @param  \App\User  $user
     * @param  \App\TicketReply  $ticketReply
     * @return mixed
     */
    public function view(User $user, TicketReply $ticketReply)
    {
        return $ticketReply->ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can create ticket replies.
     *
     * @param  \App\User $user
     * @param Ticket $ticket
     * @return mixed
     */
    public function create(User $user,Ticket $ticket)
    {
        return $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can update the ticket reply.
     *
     * @param  \App\User  $user
     * @param  \App\TicketReply  $ticketReply
     * @return mixed
     */
    public function update(User $user, TicketReply $ticketReply)
    {
        return $ticketReply->ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the ticket reply.
     *
     * @param  \App\User  $user
     * @param  \App\TicketReply  $ticketReply
     * @return mixed
     */
    public function delete(User $user, TicketReply $ticketReply)
    {
        return $ticketReply->ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the ticket reply.
     *
     * @param  \App\User  $user
     * @param  \App\TicketReply  $ticketReply
     * @return mixed
     */
    public function restore(User $user, TicketReply $ticketReply)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the ticket reply.
     *
     * @param  \App\User  $user
     * @param  \App\TicketReply  $ticketReply
     * @return mixed
     */
    public function forceDelete(User $user, TicketReply $ticketReply)
    {
        //
    }
}
