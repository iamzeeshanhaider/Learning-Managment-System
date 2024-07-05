<?php

namespace App\Http\Controllers;

use App\Models\{ChatLayer, ChatQuestion};
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class ChatQuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return view(
        //     'jambasangsang.backend.questions.index',
        //     [
        //         'questions' => ChatLayer::whereSlug($slug)->questions()
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
        return view('jambasangsang.backend.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuestionRequest $request)
    {
        try {
            $chatLayerId = session('chatLayerId'); // fetch the chatLayerId from session data
            $question = new ChatQuestion($request->validated());
            $question->chat_layer_id = $chatLayerId; // assuming 'id' is the primary key of ChatLayer model
            $question->save();
            LaravelFlash::withSuccess('Layer Question Successfully');
            return redirect()->route('chat_questions.show', [$chatLayerId]);

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
    public function show($id)
    {
        // var_dump($id);
        $layer = ChatLayer::findOrFail($id);
        session()->put('chatLayerId', $id);
        return view(
            'jambasangsang.backend.questions.index',
            [
                'questions' => $layer->questions,
                'chatLayer' => $layer->id
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatQuestion $chat_question)
    {
        return view('jambasangsang.backend.questions.edit', compact('chat_question'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuestionRequest $request, ChatQuestion $chat_question)
    {
        try {
            $chatLayerId = $chat_question->chat_layer_id; // fetch the chatLayerId from session data
            $chat_question->update($request->validated());
            $chat_question->save();
            LaravelFlash::withSuccess('Question Updated Successfully');
            return redirect()->route('chat_questions.show', [$chatLayerId]);

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
