<?php

namespace App\Http\Controllers;

use App\Events\TicketUpdated;
use App\Http\Resources\API\V1\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Jambasangsang\Flash\Facades\LaravelFlash;

class TicketsController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->get('category') ? TicketCategory::find($request->get('category')) : null;
        return view('jambasangsang.backend.support.tickets.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $view = $request->get('view');
        $category = $request->get('category');
        $variables = collect([
            'type' => 'ticket',
            'file' => 'backend.support.tickets.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'category', 'view']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:ticket_categories,id',
            'user_id' => 'nullable|exists:users,id',
            'message' => 'required',
            'instructor_id' => 'nullable|exists:users,id',
            'status' => 'nullable|in:open,closed,resolved',
            'priority' => 'nullable|in:low,medium,high',
            'image' => 'nullable|image',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json(['errors' => $validator->errors()], 422);
            } else {
                return back()->withErrors($validator)->withInput();
            }
        }

        try {
            DB::beginTransaction();

            // Create the ticket in the database
            $ticketData = array_merge($validator->validated(), ['user_id' => $request->input('user_id') ?? auth()->id()]);
            $ticket = Ticket::create($ticketData);

            if ($request->hasFile('image')) {
                $ticket->image  = uploadOrUpdateFile($request->file('image'), $ticket->image, \constPath::TicketImage);
            } else {
                $ticket->image = null;
            }

            $ticket->save();

            DB::commit();

            $message = 'Ticket Created Successfully. You will be contacted shortly';

            if ($request->wantsJson()) { // Check if the request wants JSON response
                return response()->json([
                    'message' => $message,
                    'ticket' => new TicketResource($ticket),
                ]);
            } else { // For web requests
                LaravelFlash::withSuccess($message);
                return redirect()->back();
            }
        } catch (\Throwable $th) {

            DB::rollback();
            if ($request->wantsJson()) { // Check if the request wants JSON response
                return response()->json(['error' => $th->getMessage()], 422);
            } else { // For web requests
                LaravelFlash::withError($th->getMessage());
                return back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return view('jambasangsang.backend.support.tickets.partials.show', compact('ticket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ticket $ticket)
    {
        $view = $request->get('view');
        $variables = collect([
            'type' => 'ticket',
            'title' => $view ? 'Preview Attachment' : 'Edit',
            'file' => 'backend.support.tickets.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'ticket', 'view']))->render();
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Check if the user is authorized to update the ticket
        $this->authorize('update', $ticket);

        // Validate request data
        $validatedData = $request->validate([
            'instructor_id' => 'nullable|exists:users,id',
            'status' => 'required|in:open,closed,resolved',
            'priority' => 'required|in:low,medium,high',
        ]);

        try {
            // Start a database transaction
            DB::beginTransaction();

            // Create/update the ticket in the database
            $ticket->update($validatedData);

            broadcast(new TicketUpdated($ticket))->toOthers();

            // Commit the transaction
            DB::commit();

            LaravelFlash::withSuccess('Ticket Updated Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            // If an error occurs, rollback the transaction and show the error message
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
