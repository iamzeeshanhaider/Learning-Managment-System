<?php

namespace App\Http\Controllers\API\V1;

use App\Events\TicketUpdated;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\TicketResource;
use App\Models\Ticket;
use App\Traits\TablePagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketController extends Controller
{
    use TablePagination;

    private $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    private function checkTicketAccess(Ticket $ticket): void
    {
        if (!$this->user->isAdmin() && ($ticket->user->id !== $this->user->id || $ticket->instructor && $ticket->instructor->id !== $this->user->id)) {
            throw new \Exception('You do not have access to this ticket', 422);
        }
    }

    public function index(Request $request)
    {
        $order = $request->input('order_dir', 'desc');
        $per_page = $request->input('per_page', 10);

        try {
            $tickets_data = $this->user->tickets()->with('comments')->latest()->orderBy('id', $order)->paginate($per_page);
            $tickets = TicketResource::collection($tickets_data);
            $paginationData = $this->paginate($tickets_data);

            return response()->json([
                'message' => 'Tickets Retrieved',
                'tickets' => $tickets,
                'pagination' => $paginationData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode() ?? 422);
        }
    }

    public function show(Ticket $ticket)
    {
        try {
            $this->checkTicketAccess($ticket);
            $ticket->loadMissing('comments');

            return response()->json([
                'message' => 'Ticket Retrieved',
                'tickets' => new TicketResource($ticket),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function comment(Request $request, Ticket $ticket)
    {
        try {
            $this->checkTicketAccess($ticket);

            $validator = Validator::make($request->all(), [
                'comment' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            DB::beginTransaction();

            $commentData = array_merge($validator->validated(), ['user_id' => auth()->id()]);
            $ticket->comments()->create($commentData);

            broadcast(new TicketUpdated($ticket))->toOthers();

            DB::commit();

            return response()->json([
                'message' => 'Comment Added',
                'tickets' => new TicketResource($ticket),
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
