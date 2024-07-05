<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Jambasangsang\Flash\Facades\LaravelFlash;

class EventController extends Controller
{

    public function index()
    {
        return view('jambasangsang.backend.events.index');
    }


    public function create()
    {
        $event = null;

        $variables = collect([
            'type' => 'events_/_news',
            'size' => 'xl',
            'file' => 'backend.events.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'event']))->render();
    }

    public function show(Event $event)
    {
        $variables = collect([
            'type' => 'events_/_news',
            'title' => 'show',
            'size' => 'xl',
            'file' => 'backend.events.partials.show'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'event']))->render();
    }


    public function edit(Event $event)
    {
        $variables = collect([
            'type' => 'events_/_news',
            'title' => 'update',
            'size' => 'xl',
            'file' => 'backend.events.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'event']))->render();
    }


    public function destroy(Event $event)
    {
        try {
            // delete event notification
            $event->eventNotifications()->delete();

            // delete event group batches
            $event->batch()->detach();

            //  delete event
            $event->delete();

            LaravelFlash::withSuccess('Operation Successful');
            return redirect()->back();

        } catch(\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }
}
