<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Course;

class CourseController extends Controller
{


    public function index()
    {
        $courses = Course::FrontEndCourse()->paginate(6);
        return view('jambasangsang.frontend.courses.index', compact('courses'));
    }

    public function single(Course $course)
    {

        // dd($slug);
        // $course = Course::whereSlug($slug)->first();
        // dd($course);

        return view('jambasangsang.frontend.courses.single', [
            'related_courses' => Course::FrontEndCourse()->with('instructor:id,name,image,slug')->where('category_id', $course->category_id)->where('id', '!=', $course->id)->inRandomOrder()->take(2)->get(),
            'course' => $course->load('instructor:id,name,image,slug', 'students:id', 'category:id,name,slug', 'lessons', 'reviews'),
            'courses_you_may_like' => Course::FrontEndCourse()->with('instructor:id,name,image,slug')->where('id', '!=', $course->id)->inRandomOrder()->take(3)->get(),
        ]);
    }
}
