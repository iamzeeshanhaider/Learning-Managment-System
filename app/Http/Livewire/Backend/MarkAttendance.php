<?php

namespace App\Http\Livewire\Backend;

use App\Models\Attendance;
use App\Models\User;
use Livewire\Component;

class MarkAttendance extends Component
{
    public $user;

    public $date;
    public $time_in;
    public $time_out;
    public $hasCheckedIn;
    public bool $showAttendance;

    public function mount()
    {
        $this->user = User::find(auth()->id());

        $this->hasCheckedIn = $this->user->attendances()->where('date', today())->exists();
        $this->showAttendance = false;

        $this->date = date('Y-m-d');
        $this->time_in = now()->addHours(1)->format('H:i');
        $this->time_out = '';
    }

    public function toggleAttendanceModal()
    {
        $this->showAttendance = !$this->showAttendance;
    }

    public function persistAttendance()
    {
        $validatedData = $this->validate(
            [
                'date' => 'required|date',
                'time_in' => 'required',
                'time_out' => 'required|different:time_in',
            ]
        );

        Attendance::create(array_merge($validatedData, ['user_id' => $this->user->id]));

        $this->toggleAttendanceModal();

        $this->hasCheckedIn = $this->user->attendances()->where('date', today())->exists();

    }

    public function render()
    {
        return view('livewire.backend.mark-attendance');
    }
}
