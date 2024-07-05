<?php

namespace App\Http\Controllers;

use App\Models\{Chat, Conversation, ConversationMessage, User};
use Illuminate\Http\Request;
use Jambasangsang\Flash\Facades\LaravelFlash;
use App\Events\MessageSent;


class ChatRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('jambasangsang.backend.chat_requests.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat_request)
    {
        $variables = collect([
            'type' => 'request',
            'title' => 'View',
            'size' => 'xl',
            'file' => 'backend.chat_requests.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'chat_request'))->render();
    }


    public function checkconversation($senderId, $receiverId, $message, $chatId)
    {
        $sender = User::find($senderId);
        $conversation = Conversation::where('receiver_id','=',$receiverId)->first();

        if (!$conversation) {
            $conversation = Conversation::create([
                'receiver_id' => $receiverId,
                'sender_id' => $senderId,
                'chat_id' => $chatId,
                'last_time_message' => now()
            ]);
        }

        $message = ConversationMessage::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'body' => $message
        ]);

        $conversation->last_time_message = now();
        $conversation->save();

        event(new MessageSent($conversation->sender, $message, $conversation, $conversation->receiver));
        event(new MessageSent($conversation->receiver, $message, $conversation, $conversation->sender));

    }


    public function update(Request $request, Chat $chat_request)
    {
        try {

            $this->validate($request, [
                'assigned_to_id' => 'required',
            ]);

            $instructor_id = $request->input('assigned_to_id');
            $status = $request->input('status');

            if ($chat_request->assigned_to_id !== intval($instructor_id)) {
                $this->checkconversation($chat_request->created_by_id, $instructor_id, $chat_request->chat_string, $chat_request->id);
                $chat_request->assigned_to_id = $instructor_id;
            }

            $chat_request->status = $status;
            $chat_request->save();

            LaravelFlash::withSuccess('Chat Request Assigned to a Instructor Successfully');
            return redirect()->route('chat_requests.index');

        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }



}
