<?php

namespace App\Http\Livewire\Broadcast;

use Illuminate\Support\Facades\Auth;
use App\Models\{Conversation, Batch, Course};
use App\Models\User;
use Livewire\Component;

class ChatList extends Component
{
 

    public $auth_id;
    public $conversations;
    public $receiverInstance;
    public $name;
    public $selectedConversation;

    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh', 'resetComponent'];



    public function resetComponent()
    {

        $this->selectedConversation = null;
        $this->receiverInstance = null;

        # code...
    }


    public function chatUserSelected(Batch $conversation, $receiverId)
    {


        $this->selectedConversation = $conversation;
        $receiverInstance = User::find($receiverId);
        // dd($conversation);
        $this->emitTo('broadcast.chatbox', 'loadConversation', $this->selectedConversation, $receiverInstance);
        $this->emitTo('broadcast.send-message', 'updateSendMessage', $this->selectedConversation, $receiverInstance);
        // dd($conversation->toArray(), $receiverId);

        # code...
    }
    


    public function getChatUserInstance(Batch $conversation, $request)
    {
        # code...
        $this->auth_id = auth()->id();
        //get selected conversation

        if ($conversation->sender_id == $this->auth_id) {
            $this->receiverInstance = User::firstWhere('id', $this->auth_id);
            # code...
        } else {
            $this->receiverInstance = User::firstWhere('id', $this->auth_id);
        }

        if (isset($request)) {
            return $this->receiverInstance->$request;
        }
    }
    public function mount()
    {

        $user = Auth::user();
        $this->auth_id = $user->id;
        $batches = [];
        switch ($user->assignRoles()) {
            case 'Student':
                $batches = $user->batches()->orderBy('updated_at', 'DESC')->get();

                break;
            case 'Instructor':

                $courses = $user->userCourses()->with('batches')->get();

                $batches_ids = $courses->pluck('batches.*.id')->flatten()->unique();

                $batches = Batch::whereIn('id', $batches_ids)
                                ->orderBy('updated_at', 'DESC')
                                ->get();
              
                break;
            case 'Admin':
                $batches = Batch::all();
                break;
            default:
                $batches = [];
                break;
        }


   
        $user = Auth::user();

        $this->conversations = $batches;

    }

    public function render()
    {
        return view('livewire.backend.broadcast.chat-list');
    }
}
