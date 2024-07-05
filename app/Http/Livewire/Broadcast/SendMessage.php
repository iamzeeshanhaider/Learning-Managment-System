<?php

namespace App\Http\Livewire\Broadcast;

use App\Events\BroadcastSent;
use App\Models\{Conversation, Batch};
use App\Models\BroadcastMessages;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
  
class SendMessage extends Component
{
    public $selectedConversation;
    public $receiverInstance;
    public $body;
    public $createdMessage;
    protected $listeners = ['updateSendMessage', 'dispatchMessageSent','resetComponent'];


    public function resetComponent()
    {

  $this->selectedConversation= null;
  $this->receiverInstance= null;

        # code...
    }



    function updateSendMessage(Batch $conversation, User $receiver)
    {

        //  dd($conversation,$receiver);
        $this->selectedConversation = $conversation;
        $this->receiverInstance = $receiver;
        # code...
    }




    public function sendMessage()
    {
        if ($this->body == null) {
            return null;
        }


        try{
        $this->createdMessage = BroadcastMessages::create([
            'batch_id' => $this->selectedConversation->id,
            'message' => $this->body,

        ]);}
        catch(err){
            dd($err);
        }

        $this->selectedConversation->updated_at = $this->createdMessage->created_at;
        $this->selectedConversation->save();
        $this->emitTo('chat.chatbox', 'pushMessage', $this->createdMessage->id);

        //reshresh coversation list
        $this->emitTo('chat.chat-list', 'refresh');
        $this->reset('body');

        $this->emitSelf('dispatchMessageSent');
        // dd($this->body);
        # code..
    }



    public function dispatchMessageSent()
    {
        broadcast(new BroadcastSent(Auth()->user(), $this->createdMessage, $this->selectedConversation));
        # code...
    }
    public function render()
    {
        return view('livewire.backend.broadcast.send-message');
    }
}
