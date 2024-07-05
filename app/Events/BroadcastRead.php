<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel; 
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BroadcastRead implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
 
    public $conversation_id;

    public function __construct($conversation_id)
    {

        $this->conversation_id= $conversation_id;

        //
    }

    public function  broadcastWith()
    {

         return [

            'conversation_id'=>$this->conversation_id,
         ];
        # code..
    }
    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('chat.broadcast');

    }
}
