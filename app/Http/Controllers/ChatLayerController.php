<?php

namespace App\Http\Controllers;

use App\Models\ChatLayer;
use App\Http\Requests\StoreLayerRequest;
use App\Http\Requests\UpdateLayerRequest;
use Jambasangsang\Flash\Facades\LaravelFlash;

class ChatLayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Gate::authorize('view_layers');
        return view(
            'jambasangsang.backend.layers.index',
            [
                'layers' => ChatLayer::get()
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Gate::authorize('add_layers');
        return view('jambasangsang.backend.layers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLayerRequest $request)
    {
        // Gate::authorize('add_layers');

        try {

            $layer = ChatLayer::create($request->validated());
            if($layer){
                LaravelFlash::withSuccess('Layer Created Successfully');
                return redirect()->route('chat_layers.index');
            }

        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }

    }

    /**`
     * Display the specified resource.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        // Gate::authorize('view_layers');
        $layer = ChatLayer::whereSlug($slug)->firstOrFail();
        return view('jambasangsang.backend.layers.show', ['layer' => $layer]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function edit(ChatLayer $chatLayer)
    {
        // Gate::authorize('edit_layers');
        return view('jambasangsang.backend.layers.edit', compact('chatLayer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatLayer  $chatLayer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLayerRequest $request, ChatLayer $chatLayer)
    {
        // Gate::authorize('edit_layers');
        try {

            $chatLayer->update($request->validated());
            LaravelFlash::withSuccess('ChatLayer Updated Successfully');
            return redirect()->route('chat_layers.index');

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
