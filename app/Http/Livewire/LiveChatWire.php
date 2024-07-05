<?php

namespace App\Http\Livewire;
use App\Models\{ChatLayer, Chat, ChatConversation, BroadcastMessages};
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Jambasangsang\Flash\Facades\LaravelFlash;


class LiveChatWire extends Component
{
    public $currentStep = 1;
    public $formData = [];
    public $steps; // Add a property to store the fetched steps
    public $chat;
    public $issue;
    public $is_completed = false;


    public function mount()
    {
        $this->steps = ChatLayer::all();
    }


    public function render()
    {
        return view('livewire.backend.live-chat-wire', [
            'currentStep' => $this->currentStep,
            'steps' => $this->steps,
            'formData' => $this->formData,
            'is_completed' => $this->is_completed
        ]);
    }

    public function submitForm()
    {

    try {

        if($this->currentStep === 1){
            $chat = Chat::create();
            $this->chat = $chat;
        }
        foreach ($this->formData as $fieldId => $optionId) {
            $conversation = new ChatConversation([
                'chat_layer_id' => $this->steps[$this->currentStep - 1]["id"],
                'chat_question_id' => $fieldId,
                'chat_option_id' => $optionId,
            ]);

            $this->chat->conversation()->save($conversation);
        }


    $this->formData = [];

    $step_count = count($this->steps);
    $current_step = $this->currentStep;



    if ($step_count > $current_step)
    {
        $this->currentStep = $current_step + 1;
    }
    else
    {
        $user = Auth::user();
        $conversation = ChatConversation::where('chat_id', $this->chat->id)->get();

        // Create a string of chat using the retrieved conversation data
        $chatString = "";
        foreach ($conversation as $conv) {
            $chatString .= "Step Name: " . $conv->layer->name . PHP_EOL .
                            "Question: " . $conv->question->question . PHP_EOL .
                            "Selected Option: " . $conv->option->option . PHP_EOL;
        }
        $chatString .= PHP_EOL ;
        $chatString .= "Issue Brief" . PHP_EOL;
        $chatString .= $this->issue;

        //Save Broadcast Message
        $message = new BroadcastMessages();
        $message->message = $chatString;
        $message->save();
        $this->chat->issue =$this->issue;
        $this->chat->chat_string = $chatString;
        $this->chat->save();

        $this->is_completed = true;

    }

} catch (\Throwable $th) {
    $this->is_completed = false;
    LaravelFlash::withError($th->getMessage());
        return back();
}
    }
}
