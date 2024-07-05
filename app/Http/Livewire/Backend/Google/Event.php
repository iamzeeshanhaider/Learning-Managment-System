<?php

namespace App\Http\Livewire\Backend\Google;

use App\Models\Batch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class Event extends Component
{
    public $student;
    public $batch;
    public $user;
    public $events;
    public $active_event;
    public $google_events;
    public $eventId;
    public $perPage = 10;
    public $page = 1;
    public $limit = 100;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $has_meeting_link = true;
    public $show_form = false;
    public $hasMore = false;
    public $loading = false;
    public $expanded = false;
    public $show_confirmation = false;
    public $notify_attendee = true;

    public function __construct()
    {
        if (auth()->user()->calendar_id) {
            config(['google-calendar.calendar_id' => auth()->user()->calendar_id]);
        }
    }

    public function mount($student = null, $batch = null)
    {
        $this->student = $student ? User::find($student) : null;
        $this->batch = $batch ? Batch::find($batch) : null;
        $this->user = auth()->user();
        $this->loadEvents();
    }

    public function toggleForm($event = null)
    {
        $this->active_event = $event;
        $this->show_form = !$this->show_form;
    }

    /**
     * Load more events.
     */
    public function loadEvents(): void
    {
        $events = GoogleCalendarEvent::get();
        $this->events = $this->filterEvents($events);
    }

    private function filterEvents($events)
    {
        $filteredEvents = [];

        foreach ($events as $key => $event) {
            foreach ($event->attendees as $attendee) {
                $isStudentMatch = $this->student && ($attendee->email === $this->student->email);
                $isBatchMatch = $this->batch && ($attendee->comment === static::getComment($this->batch->slug));
                $isUserMatch = $this->user && !($this->student || $this->batch) && ($attendee->email === $this->user->email);

                if ($isStudentMatch || $isBatchMatch || $isUserMatch) {
                    $filteredEvents[$key] = [
                        'id' => $event->id,
                        'start' => $event->start->dateTime,
                        'end' => $event->end->dateTime,
                        'name' => $event->name,
                        'description' => $event->description,
                        'hangoutLink' => $event->hangoutLink,
                        'attendees' => array_map(function ($att) {
                            return [
                                'name' => $att->displayName,
                                'email' => $att->email,
                                'comment' => $att->comment,
                            ];
                        }, $event->attendees),
                    ];
                }
            }
        }

        return $filteredEvents;
    }

    public function toggleExpand()
    {
        $this->expanded = !$this->expanded;
    }

    // save event
    public function saveEvent()
    {
        $validatedData = $this->validate([
            'title' => 'required|max:150',
            'description' => 'nullable|max:500',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'has_meeting_link' => 'nullable',
            'notify_attendee' => 'nullable',
        ]);


        try {
            DB::beginTransaction();
            $this->loading = true;

            // Parse date
            $startDate = Carbon::parse($validatedData['start_date'] ?? now());
            $endDate = Carbon::parse($validatedData['end_date'] ?? now()->addHour());

            // Create or update GoogleCalendarEvent
            $googleCalendarEvent = $this->eventId ? GoogleCalendarEvent::find($this->eventId) : new GoogleCalendarEvent;

            $googleCalendarEvent->name = $validatedData['title'];
            $googleCalendarEvent->description = $validatedData['description'] ?? null;
            $googleCalendarEvent->startDateTime = $startDate;
            $googleCalendarEvent->endDateTime = $endDate;

            foreach ($this->getAttendees() as $attendee) {
                $googleCalendarEvent->addAttendee($attendee);
            }

            if ($validatedData['has_meeting_link'] === true) {
                $googleCalendarEvent->addMeetLink();
            }

            $optParams = ['sendNotifications' => $this->notify_attendee];

            $googleCalendarEvent->save($this->eventId ? 'updateEvent' : 'insertEvent', $optParams);

            DB::commit();
            $this->loadEvents();
            $this->resetForm();

            $this->emit('displayAlert', 'success', 'Operation Successfully');
        } catch (\Throwable $th) {
            DB::rollback();
            \Log::error('Ticket Creation Failed', ['exception' => $th]);
            $this->emit('displayAlert', 'danger', $th->getMessage());
            $this->reset(['loading']);
        }
    }

    public function resetForm()
    {
        $this->reset(['title', 'description', 'start_date', 'end_date', 'has_meeting_link', 'loading', 'show_form', 'show_confirmation', 'active_event', 'eventId']);
    }

    private function getAttendees(): array
    {
        $attendees = [];

        if ($this->batch) {
            foreach ($this->batch->students as $student) {
                $attendees[] = [
                    'name' => $student['name'] . ' ' . $student['lname'],
                    'email' => $student['email'],
                    'comment' => static::getComment($this->batch->slug),
                ];
            }
        }

        if ($this->student) {
            $attendees[] = [
                'name' => $this->student['name'] . ' ' . $this->student['lname'],
                'email' => $this->student['email'],
                'comment' => static::getComment($this->user->email),
            ];
        }

        $attendees[] = [
            'name' => $this->user->name . $this->user->lname,
            'email' => $this->user->email,
            'comment' => 'host',
        ];

        return $attendees;
    }

    public static function getComment($string)
    {
        return 'invitedBy_' . $string;
    }

    public function editEvent($eventId)
    {
        $this->eventId = $eventId;
        $event = GoogleCalendarEvent::find($eventId);
        $this->title = $event->name;
        $this->description = $event->description;
        $this->start_date = parseDateTime($event->start->dateTime)->format('Y-m-d\TH:i');
        $this->end_date = parseDateTime($event->end->dateTime)->format('Y-m-d\TH:i');
        $this->has_meeting_link = $event->hangoutLink ? true : false;
        $this->show_form = true;
        $this->notify_attendee = false;
    }

    public function confirmDelete($eventId)
    {
        $this->show_confirmation = true;
        $this->eventId = $eventId;
    }

    public function deleteEvent()
    {
        $this->loading = true;

        try {
            if ($this->eventId) {
                $g_event = GoogleCalendarEvent::find($this->eventId);
                $g_event->delete();
            }

            $this->loadEvents();
            $this->resetForm();

            $this->emit('displayAlert', 'success', 'Operation Successfully');
        } catch (\Throwable $th) {
            $this->emit('displayAlert', 'danger', $th->getMessage());
        }
        $this->show_confirmation = false;
        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.backend.google.event');
    }
}
