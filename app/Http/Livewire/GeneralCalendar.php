<?php

namespace App\Http\Livewire;

use App\Models\BatchUser;
use App\Models\Course;
use App\Models\Event;
use App\Models\Quiz;
use Asantibanez\LivewireCalendar\LivewireCalendar;
use Illuminate\Support\Collection;
use Spatie\GoogleCalendar\Event as GoogleCalendarEvent;

class GeneralCalendar extends LivewireCalendar
{
    public function __construct()
    {
        if (auth()->user()->calendar_id) {
            config(['google-calendar.calendar_id' => auth()->user()->calendar_id]);
        }
    }

    public function events(): Collection
    {
        $course_data = [];
        $quiz_data = [];
        $batch_user_data = [];
        $user = auth()->user();
        $isAdmin = $user->isAdmin(); // bool check

        // get next payment date via batch user data
        $batches_data = $isAdmin ? BatchUser::query() : BatchUser::query()->where('student_id', $user->id);
        $batches_data = $batches_data->whereDate('next_payment_due_date', '>=', $this->gridStartsAt)->get();

        // get all courses for admin and only enrolled couress for student
        $courses = $isAdmin ? Course::query() : auth()->user()->courses()->withPivot('id');
        $courses = $courses->whereDate('start_date', '>=', $this->gridStartsAt)->orWhereDate('end_date', '<=', $this->gridEndsAt)->get();

        // get events
        $events = Event::Published()->whereDate('date', '>=', $this->gridStartsAt)->orWhereDate('date', '<=', $this->gridEndsAt)->get();
        $events_data = $events->map(function (Event $event) use ($isAdmin) {
            return [
                'id' => $event->id,
                'slug' => $event->slug,
                'title' => 'Event',
                'url' => route('events.show', [$event->slug]),
                'description' => str_limit($event->title, 50),
                'type' => 'event',
                'date' => $event->date,
            ];
        });

        $course_data = $courses->map(function (Course $course) use ($isAdmin) {
            return [
                'id' => $course->id,
                'slug' => $course->slug,
                'title' => 'Course',
                'url' => $isAdmin ? route('courses.show', ['course' => $course->slug]) : route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course->id]),
                'description' => str_limit($course->title, 50),
                'type' => 'course',
                'date' => $course->start_date,
            ];
        });

        if($batches_data) {
            $batch_user_data = $batches_data->map(function (BatchUser $batch_user) {
                return [
                    'id' => $batch_user->id,
                    'slug' => $batch_user->course->slug,
                    'title' => 'Due Payment',
                    'url' => '',
                    // 'url' => $isAdmin ? route('courses.show', ['course' => $course->slug]) : route('student.courses.show', ['batch' => $course->pivot->batch_id, 'course' => $course->id]),
                    'description' => str_limit(($batch_user->student->name. ' '.$batch_user->student->lname), 50),
                    'type' => 'payment',
                    'date' => $batch_user->next_payment_due_date,
                ];
            });
        }

        if ($isAdmin) {
            // Return all quiz for admin
            $quiz_data = Quiz::query()
                ->whereDate('start_time', '>=', $this->gridStartsAt)
                ->orWhereDate('end_time', '<=', $this->gridEndsAt)
                ->get()
                ->map(function (Quiz $quiz) {
                    return [
                        'id' => $quiz->id,
                        'slug' => $quiz->slug,
                        'title' => 'Quiz',
                        'url' => route('quiz.show', ['course' => $quiz->course->slug, 'quiz' => $quiz->slug]),
                        'description' => str_limit(strip_tags(html_entity_decode($quiz->question)), 50),
                        'type' => 'quiz',
                        'date' => $quiz->start_time,
                    ];
                });
        } else {
            // return only quiz linked to courses that a student is enrolled in
            $studentQuizData = [];

            foreach ($courses as $course) {
                foreach ($course->quizzes as $quiz) {
                    $studentQuizData[] = [
                        'id' => $quiz->id,
                        'slug' => $quiz->slug,
                        'title' => 'Quiz',
                        'url' => route('student.quiz.attempt', ['batch_user' => $course->pivot->id, 'quizzes' => $quiz->slug, 'action' => 'init']),
                        'description' => str_limit(strip_tags(html_entity_decode($quiz->question)), 50),
                        'type' => 'quiz',
                        'date' => $quiz->start_time,
                    ];
                }
            }

            // remove duplicate items
            $quiz_data = collect($studentQuizData)->unique('id')->values()->all();
        }

        $calendar_data = static::getCalendarEvents($user);

        $merged_data = $course_data
                        ->merge($quiz_data) // merge quiz data
                        ->merge($batch_user_data) // merge batch user data
                        ->merge($events_data) // merge events data
                        ->merge($calendar_data); // merge calendar data

        return collect($merged_data);
    }

    public static function getCalendarEvents($user)
    {
        $events = GoogleCalendarEvent::get();
        $filteredEvents = collect();

        

        foreach ($events as $event) {
            foreach ($event->attendees as $attendee) {
                if ($attendee->email === $user->email) {
                    $filteredEvents->push([
                        'id' => $event->id,
                        'slug' => $user->slug,
                        'title' => 'Google Meet',
                        'url' => $event->hangoutLink,
                        'description' => $event->name,
                        'type' => 'external',
                        'date' => parseDateTime($event->start->dateTime)->format('Y-m-d\TH:i'),
                    ]);
                }
            }
        }

        return $filteredEvents;
    }

    // public function render()
    // {
    //     return view('livewire.general-calendar');
    // }
}
