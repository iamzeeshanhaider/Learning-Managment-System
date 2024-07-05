<?php

namespace App\Observers;

use App\Events\TicketUpdated;
use App\Models\Ticket;
use App\Models\User;
use App\Notifications\SupportTicketCreated;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        $notificationSubject = 'New Support Ticket';
        $admins = User::Admin()->get();

        // Notify user and admins about the new ticket
        $ticket->user->notify(new SupportTicketCreated('student', $ticket, $notificationSubject, 'A support ticket has been opened. One of our Admins will respond shortly'));

        foreach ($admins as $admin) {
            $admin->notify(new SupportTicketCreated('admin', $ticket, $notificationSubject, 'A support ticket has been opened. Kindly respond immediately'));
        }

        // Notify assigned instructor and support email if available
        if ($ticket->instructor) {
            $ticket->instructor->notify(new SupportTicketCreated('instructor', $ticket, 'A new ticket has been assigned to you', 'You have been assigned to a new ticket, please treat as important'));
        }

        if (config('app.support_email')) {
            (new User)->forceFill([
                'id' => User::latest()->first()->id + 2,
                'name' => 'Student Support',
                'email' => config('app.support_email'),
            ])->notify(new SupportTicketCreated('support', $ticket, $notificationSubject, 'A support ticket has been opened. Kindly respond immediately'));
        }
    }

    /**
     * Handle the Ticket "updated" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        // Check if there are changes that require notifications
        $notify_instructor = request()->has('instructor_id') && request()->get('instructor_id') !== ($ticket->instructor_id ?? null);
        $notify_student = request()->has('status') && request()->get('status') !== ($ticket->status ?? null);


        // Send notifications if necessary
        if ($notify_student  && $ticket->user) {
            $ticket->user->notify(new SupportTicketCreated('student', $ticket, 'Support Ticket has been ' . ucwords($ticket->status), 'Your support ticket has been updated'));
        }

        if ($notify_instructor && $ticket->instructor) {
            $ticket->instructor->notify(new SupportTicketCreated('instructor', $ticket, 'A new ticket has been assigned to you', 'You have been assigned to a new ticket, please treat as important'));
        }

        broadcast(new TicketUpdated($ticket))->toOthers();

    }

    /**
     * Handle the Ticket "deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function deleted(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function restored(Ticket $ticket)
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return void
     */
    public function forceDeleted(Ticket $ticket)
    {
        //
    }
}
