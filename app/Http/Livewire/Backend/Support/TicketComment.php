<?php

namespace App\Http\Livewire\Backend\Support;

use App\Events\TicketUpdated;
use App\Models\Ticket;
use App\Models\TicketComment as ModelTicketComment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;


/**
 * Class TicketComment
 * @package App\Http\Livewire\Backend\Support
 *
 * Livewire component for handling ticket comments in the backend.
 */
class TicketComment extends Component
{
    use WithFileUploads;

    public $ticket;
    public $content, $image;
    public $comments;
    public $perPage = 10;
    public $page = 1;
    public $hasMore = false, $loading = false;


    protected $listeners = [
        'echo:ticket_comment,TicketUpdated' => 'updateComments'
    ];

    /**
     * Mount the component and load initial comments for the ticket.
     *
     * @param Ticket $ticket
     */
    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket;
        $this->loadMessages();
    }

    public function updateComments()
    {
        $this->loadMessages();
    }

    /**
     * Load ticket comments based on the current page and perPage value.
     */
    private function loadMessages(): void
    {
        $query = ModelTicketComment::where('ticket_id', $this->ticket->id)->with('attachment')->latest('created_at', 'asc');

        $perPage = $this->perPage;
        $page = $this->page;

        $this->hasMore = $query->skip($perPage * $page)->take(1)->exists();

        // Fetch comments for the current page using forPage() method
        $commentsForPage = $query->forPage($page, $perPage)->get();

        // Group the fetched comments by the date part of 'created_at'
        $groupedComments = $commentsForPage->groupBy(function ($item) {
            return $item->created_at->toDateString();
        })->all();

        if ($this->page === 1) {
            $this->comments = $groupedComments;
        } else {
            $this->comments = $this->comments->merge($groupedComments);
        }
    }


    /**
     * Load more comments when the "Load More" button is clicked.
     */
    public function loadMore()
    {
        $this->page++;
        $this->loadMessages();
    }

    /**
     * Send a new comment for the ticket.
     */
    public function addComment()
    {
        $this->loading = true;

        $validatedData = $this->validate([
            'content' => 'required|max:65000',
            'image' => 'nullable|image'
        ]);

        try {
            DB::beginTransaction();

            $comment = $this->ticket->comments()->create([
                'comment' => $validatedData['content'],
                'user_id' => auth()->id()
            ]);

            if ($validatedData['image']) {
                $path = $validatedData['image']->store(\constPath::CommentAttachment, config('filesystems.default'));
                if(config('filesystems.default') === 's3') {
                    $path = Storage::disk('s3')->url($path);
                }

                $comment->attachment()->create([
                    'image' => $path
                ]);
            }
            broadcast(new TicketUpdated($this->ticket))->toOthers();

            DB::commit();

            $this->loadMessages();
            $this->reset(['content', 'loading', 'image']);
            $this->emit('clearCKEditor');

        } catch (\Throwable $th) {
            DB::rollback();
            \Log::info('Ticket Comment Failed:: ' . $th);
            $this->reset(['loading']);
        }
    }

    /**
     * Clear image for upload
     *
     */
    public function clearImage(): void
    {
        $this->image = null;
    }

    /**
     * Render the Livewire component.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('livewire.backend.support.ticket-comment');
    }
}
