<?php

namespace App\Events;

use App\Models\Batch;
use App\Models\BroadcastMessages; 
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $message;
    public $conversation;

    public function __construct(User $user, BroadcastMessages $message, Batch $conversation)
    {

        $this->user = $user;
        $this->message = $message;
        $this->conversation = $conversation;
    }


    public function broadcastWith()
    {

        return [
            'user_id' => $this->user->id,
            'message' => $this->message->id,
            'conversation_id' => $this->conversation->id,
        ];
        # code...
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        error_log($this->user);
        return new Channel('chat.broadcast');
    }
}
