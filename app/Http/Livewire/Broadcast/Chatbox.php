<?php

namespace App\Http\Livewire\Broadcast;

use App\Events\BroadcastSent;
use App\Events\BroadcastRead;
use App\Models\{Conversation, Batch};
use App\Models\BroadcastMessages;
use App\Models\User;
use Livewire\Component;
 

class Chatbox extends Component
{

    public $selectedConversation;
    public $receiver;
    public $messages;
    public $paginateVar = 10;
    public $height;

    // protected $listeners = [ 'loadConversation', 'pushMessage', 'loadmore', 'updateHeight', "echo-private:chat. {$auth_id},MessageSent"=>'broadcastedMessageReceived',];


    public function  getListeners()
    {
        $auth_id = auth()->user()->id;
        return [
            "echo:chat.broadcast,BroadcastSent" => 'broadcastedMessageReceived',
            "echo:chat.broadcast,BroadcastRead" => 'broadcastedMessageRead',
            'loadConversation', 'pushMessage', 'loadmore', 'updateHeight','broadcastMessageRead','resetComponent'
        ];
    }



    public function resetComponent()
  {

$this->selectedConversation= null;
$this->receiverInstance= null;

      # code...
  }

    public function broadcastedMessageRead($event)
    {

        if($this->selectedConversation){



            if((int) $this->selectedConversation->id === (int) $event['conversation_id']){

                $this->dispatchBrowserEvent('markMessageAsRead');
            }

        }

        # code...
    }
    /*---------------------------------------------------------------------------------------*/
    /*-----------------------------Broadcasted Event fucntion-------------------------------------------*/
    /*----------------------------------------------------------------------------*/

    function broadcastedMessageReceived($event)
    {

        ///here
      $this->emitTo('chat.chat-list','refresh');
        # code...

        $broadcastedMessage = BroadcastMessages::find($event['message']);
        if ($this->selectedConversation) {
            if ((int) $this->selectedConversation->id  === (int)$event['conversation_id']) {
               
                $this->pushMessage($broadcastedMessage->id);

                $this->emitSelf('broadcastMessageRead');
            }
        }
    }


    public function broadcastMessageRead( )
    {
        try {
            broadcast(new BroadcastRead($this->selectedConversation->id));
        } catch (\Throwable $th) {
            \Log::info($th);
        }
        # code...
    }

    /*--------------------------------------------------*/
    /*------------------push message to chat--------------*/
    /*------------------------------------------------ */
    public function pushMessage($messageId)
    {
        $newMessage = BroadcastMessages::find($messageId);
        $this->messages->push($newMessage);
        $this->dispatchBrowserEvent('rowChatToBottom');
        # code...
    }



    /*--------------------------------------------------*/
    /*------------------load More --------------------*/
    /*------------------------------------------------ */
    function loadmore()
    {

        // dd('top reached ');
        $this->paginateVar = $this->paginateVar + 10;
        $this->messages_count = BroadcastMessages::where('batch_id', $this->selectedConversation->id)->count();

        $this->messages = BroadcastMessages::where('batch_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $height = $this->height;
        $this->dispatchBrowserEvent('updatedHeight', ($height));
        # code...
    }


    /*---------------------------------------------------------------------*/
    /*------------------Update height of messageBody-----------------------*/
    /*---------------------------------------------------------------------*/
    function updateHeight($height)
    {

        // dd($height);
        $this->height = $height;

        # code...
    }



    /*---------------------------------------------------------------------*/
    /*------------------load conersation----------------------------------*/
    /*---------------------------------------------------------------------*/
    public function loadConversation(Batch $conversation, User $receiver)
    {

        $this->selectedConversation =  $conversation;
        $this->receiverInstance =  $receiver;

        $this->messages_count = BroadcastMessages::where('batch_id', $this->selectedConversation->id)->count();

        $this->messages = BroadcastMessages::where('batch_id',  $this->selectedConversation->id)
            ->skip($this->messages_count -  $this->paginateVar)
            ->take($this->paginateVar)->get();

        $this->dispatchBrowserEvent('chatSelected');

    }
    public function render()
    {
        return view('livewire.backend.broadcast.chatbox');
    }
}
