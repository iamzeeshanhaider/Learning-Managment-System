<?php

namespace App\Http\Livewire\Backend;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Notification extends Component
{
    public $notifications, $total_notifications;

    public function mount()
    {
        // Load the initial notifications for the authenticated user
       $this->initializeNotifications();
    }

    public function initializeNotifications()
    {
        $this->notifications = Auth::user()->unreadNotifications->take(8);
        $this->total_notifications = Auth::user()->unreadNotifications->count();
    }

    public function markAsRead($notification)
    {
        // Mark the notification as read
        $notification = Auth::user()->notifications()->findOrFail($notification);
        $notification->markAsRead();

        // Update the notifications array
        $this->initializeNotifications();
    }

    public function markAllAsRead()
    {
        // Mark all notifications as read
        Auth::user()->unreadNotifications->markAsRead();

        // Update the notifications array
        $this->notifications = Auth::user()->unreadNotifications;
    }

    public function render()
    {
        return view('livewire.backend.notification');
    }
}
