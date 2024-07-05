<?php

namespace App\Http\Controllers;

use App\Models\{Chat, BroadcastMessages, Conversation, CourseUser};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Jambasangsang\Flash\Facades\LaravelFlash;
use App\Facades\PusherFacade;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jambasangsang.backend.live_chat.broadcast');
    }



    public function chatroom()
    {
        return view('jambasangsang.backend.live_chat.chatroom');

    }


    public function chat_assign(Conversation $chat)
    {
            $variables = collect([  
            'type' => 'chat',
            'title' => 'manage',
            'size' => 'md',
            'file' => 'backend.live_chat.assign'
        ]);


        return view('components.partials.general-modal', compact('variables', 'chat'))->render();
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jambasangsang.backend.live_chat.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // Gate::authorize('add_comment_ticket');
        $this->validate($request, [
            'message' => 'required'
        ]);

        $user = Auth::user();

        try {
            $message = BroadcastMessages::create([
                'message' => $request->input('message'),
                'batch_id' => $request->input('batch_id')
            ]);


            $options = array(
                'cluster' => 'ap2',
                'useTLS' => true
            );


            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );


            $broadcast_object = [
                "user" => $user,
                "message" => $request->input('message'),
                "created_at" => $message->created_at,
            ];

            $pusher->trigger('live-chat-broadcast', 'chat_push', $broadcast_object);
            // PusherFacade::trigger('live-chat-broadcast', 'chat_push', $broadcast_object);

            return ("Success");

        } catch (\Throwable $th) {
            return $th;
        }

    }



}
