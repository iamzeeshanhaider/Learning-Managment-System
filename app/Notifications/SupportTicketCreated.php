<?php

namespace App\Notifications;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketCreated extends Notification
{
    use Queueable;

    public $ticket, $role;
    public $description, $subject;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($role, Ticket $ticket, $subject, $description)
    {
        $this->role = $role;
        $this->ticket = $ticket;
        $this->subject = $subject;
        $this->description = $description;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // Check if the user's role is 'system'
        if ($this->role === 'system') {
            // Notify only through email
            return ['mail'];
        } else {
            // Notify through both email and database
            return ['mail', 'database'];
        }
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->subject($this->subject)->markdown('emails.support.new_ticket', [
            'role' => $this->role,
            'ticket' => $this->ticket,
            'subject' => $this->subject,
            'description' => $this->subject,
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'subject' => $this->subject,
            'description' => $this->description,
            'data' => [
                'url' => route('tickets.show', $this->ticket->slug),
                'subject' => $this->ticket->category->name,
                'body' => $this->ticket->message
            ],
        ];
    }
}
