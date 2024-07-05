<?php

namespace App\Http\Livewire\Backend\SelectFilter;

use App\Models\Batch;
use Livewire\Component;

class Batches extends Component
{
    public $query = '';
    public $batches;
    public $activeBatch;
    public bool $is_user_batch;
    public $selected;

    public function mount($selected = null, $is_user_batch = false)
    {
        $this->selected = $selected;
        $this->activeBatch = getActiveBatch();
        $this->is_user_batch = $is_user_batch;

        $user = auth()->user();
        $this->batches = $user->isStudent() ? $user->batches->unique('id') : Batch::query()->get(['id', 'slug', 'name']);
    }

    public function searchBatch()
    {
        if($this->query) {
            $this->batches = Batch::query()->limit(10)->where('name', 'like', '%' . $this->query . '%')->get(['id', 'slug', 'name']);
        } else {
            $this->batches = Batch::query()->limit(10)->get(['id', 'slug', 'name']);
        }
    }

    public static function setActiveBatch(Batch $batch)
    {
        session(['active_batch' => $batch]);

        return redirect(request()->header('Referer'));
    }


    public function render()
    {
        return view('livewire.backend.select-filter.batches');
    }
}
