<?php

namespace App\Http\Livewire\Backend;

use App\Models\EventNotification;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class EventNotifications extends Component
{
    public $notifications;

    public function mount()
    {
        // Load the initial notifications for the authenticated user
        $this->notifications = Auth::user()->unreadEventNotifications;
    }

    public function markAsRead(EventNotification $notification)
    {
        // Mark the notification as read
        $notification->markAsRead();

        // Update the notifications array
        $this->notifications = Auth::user()->unreadEventNotifications;

    }

    public function markAllAsRead()
    {
        // Mark all notifications as read
        Auth::user()->unreadEventNotifications->each->markAsRead();

        // Update the notifications array
        $this->notifications = Auth::user()->unreadEventNotifications;
    }

    public function render()
    {
        // Update the notifications array
        $this->notifications = Auth::user()->unreadEventNotifications;

        return view('livewire.backend.event-notifications');
    }
}
