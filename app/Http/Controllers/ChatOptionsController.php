<?php

namespace App\Http\Controllers;

use App\Models\{ChatLayer, ChatQuestion, ChatOption};
use App\Http\Requests\StoreOptionRequest;
use App\Http\Requests\UpdateOptionRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class ChatOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view(
        //     'jambasangsang.backend.options.index',
        //     [
        //         'options' => ChatQuestion::whereSlug($slug)->options()
        //     ]
        // );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jambasangsang.backend.options.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOptionRequest $request)
    {
        try {
            $chatQuestionId = session('chatQuestionId'); // fetch the chatLayerId from session data
            $option = new ChatOption($request->validated());
            $option->chat_question_id = $chatQuestionId; // assuming 'id' is the primary key of ChatLayer model
            $option->save();
            session()->forget('chatQuestionId');
            LaravelFlash::withSuccess('Layer Option Successfully');
            return redirect()->route('chat_options.show', [$chatQuestionId]);

        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function show($chatQuestionId)
    {
        $question = ChatQuestion::findOrFail($chatQuestionId);
        session()->put('chatQuestionId', $question->id);
        return view(
            'jambasangsang.backend.options.index',
            [
                'options' => $question->options,
                'chatQuestion' => $question->id
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatOption $chat_option)
    {
        return view('jambasangsang.backend.options.edit', compact('chat_option'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOptionRequest $request, ChatOption $chat_option)
    {

        try {
            $chatQuestionId = $chat_option->chat_question_id; // fetch the chatLayerId from session data
            $chat_option->update($request->validated());
            $chat_option->save();
            LaravelFlash::withSuccess('Option Updated Successfully');
            return redirect()->route('chat_options.show', [$chatQuestionId]);

        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function destroy(ChatLayer $chatLayer)
    {
        //
    }
}
