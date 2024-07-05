<?php

namespace App\Http\Controllers;

use App\Enums\Gender;
use App\Enums\GeneralStatus;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Event;
use App\Models\Payment;
use App\Models\User;

class HomeController extends Controller
{

    public function index()
    {
        $cousesAndStudents = auth()->user()->hasRole('Instructor')
                    ? auth()->user()->userCourses()->withCount('students')->get()
                    : (auth()->user()->hasRole('Student')
                        ? auth()->user()->courses()->where('batch_id', getActiveBatch()->id)
                                        ->withCount(['students', 'lessons', 'quizzes'])
                                        ->with([
                                            'quizzes' => fn($q) => $q->whereHas('questions')
                                                                        ->where('status', GeneralStatus::Enabled)
                                                                        ->whereBetween('start_time', [now()->startOfWeek(), now()->endOfWeek()])
                                                                        ->orWhereBetween('end_time', [now()->startOfWeek(), now()->endOfWeek()]),
                                        ])
                                        ->withPivot(['id', 'student_id', 'course_id'])->latest()->get()
                        : Course::withCount('students')->get());

        return view(
            'home',
            [
                'totalSales' => Payment::sum('amount_paid'),
                'numberOfAdmins' => User::Admin()->count(),
                'numberOfInstructors' => User::Instructor()->count(),
                'numberOfStudents' => User::Student()->count(),

                'numberOfMaleStudents' => User::Student()->where('gender', Gender::Male)->count(),
                'numberOfFemaleStudents' => User::Student()->where('gender', Gender::Female)->count(),
                'numberOfOtherGenderStudents' => User::Student()->where('gender', Gender::Others)->count(),


                'numberOfInactiveCourses' => auth()->user()->hasRole('Instructor') ? auth()->user()->userCourses()->where('status', GeneralStatus::Disabled)->count() : Course::count(),

                'numberOfActiveStudents' => User::Student()->where('status', GeneralStatus::Enabled)->count(),
                'numberOfInactiveStudents' => User::Student()->where('status', GeneralStatus::Disabled)->count(),

                'numberOfCoursesAndStudents' => $cousesAndStudents,

                'events' => Event::where('status', 'Enabled')->get(['id', 'title', 'created_at']),
                'batches' => Batch::withCount('students')->get(['id', 'name']),
            ]
        );
    }
}
