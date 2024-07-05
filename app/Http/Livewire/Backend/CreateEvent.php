<?php

namespace App\Http\Livewire\Backend;

use App\Enums\EventGroup;
use App\Enums\GeneralStatus;
use App\Models\Event;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateEvent extends Component
{
    use WithFileUploads;

    public $event;
    public $title, $content, $date, $status, $banner, $group, $batch_id;
    public $notify_group = false;

    public function mount($event = null)
    {
        $this->event = $event;
        $this->title = $this->event->title ?? '';
        $this->content = $this->event->content ?? '';
        $this->date = $this->event ? $this->event->date->format('Y-m-d H:i') : '';
        $this->status = $this->event->status ?? GeneralStatus::Enabled;
        $this->group = $this->event ? EventGroup::coerce($this->event->group)->value : EventGroup::AllUsers;
        $this->banner = '';
        $this->notify_group = false;
        $this->setBatch();
    }

    public function setBatch()
    {
        if($this->group === EventGroup::ByBatch) {
            $this->batch_id = $this->event && $this->event->batch ? $this->event->batch()->pluck('batch_id') : [];
        } else {
            $this->batch_id = [];
        }
    }

    public function persistEvent()
    {
        $validatedData = $this->validate(
            [
                'title' => 'required|max:150|'. ($this->event ? 'unique:events,title,'.$this->event->id : 'unique:events,title'),
                'content' => 'nullable|max:500',
                'date' => 'required|date',
                'status' => ['required', new EnumValue(GeneralStatus::class)],
                'banner' => 'nullable|image',
                'group' => 'required',
                'batch_id' => 'required_if:group,' . EventGroup::ByBatch,
                'notify_group' => 'nullable|',
            ],
        );

        $message = 'Event ' . ($this->event ? 'Updated' : 'Created') . ' Successfully!';

        // Save validated data to database
        try {
            DB::beginTransaction();

            // Create or update event
            $event = $this->event ?? new Event();

            $event->created_by = auth()->id();
            $event->title = $validatedData['title'];
            $event->content = $validatedData['content'];
            $event->date = $validatedData['date'];
            $event->status = $validatedData['status'];
            $event->group = $validatedData['group'];
            $event->notify_group = $validatedData['notify_group'];
            $event->banner = $validatedData['banner'];

            $event->save();

            // set event batch group
            if($this->group == EventGroup::ByBatch) {
                $event->batch()->sync($this->batch_id);
            }
            DB::commit();

            return redirect()->route('events.index')->with('message', $message);

        } catch (\Throwable $th) {
            DB::rollback();
            Log::error('Error Creating Event: ' . $th->getMessage());
            return redirect()->route('events.index')->with('error', $th->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.backend.create-event');
    }
}
