<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $course = $request->get('course') ? Course::where('slug', $request->get('course'))->first() : null;

        return view('jambasangsang.backend.lessons.index', compact('course'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $course = $request->get('course') ? Course::where('slug', $request->get('course'))->first() : null;

        $variables = collect([
            'type' => 'lessons',
            'file' => 'backend.lessons.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'course']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\StoreLessonRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonRequest $request)
    {
        try {
            DB::beginTransaction();
            $lesson = Lesson::create($request->validated());
            if($request->hasFile('image')) {
                $lesson->image  = uploadOrUpdateFile($request->file('image'), $lesson->image, \constPath::LessonImage);
                $lesson->save();
            }
            DB::commit();
            LaravelFlash::withSuccess('Lesson Created Successfully');
            return redirect()->route('lessons.index', [$request->slug]);

        } catch(\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function lesson_resource($slug)
    {
        $lesson = Lesson::where('slug', $slug)
                    ->with([
                        'course' => fn($q) => $q->with('course_master')
                    ])
                    ->first();

        return view('jambasangsang.backend.lessons.resources.index', compact(['lesson']));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  lesson
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Lesson $lesson)
    {
        $course = $request->get('course') ? Course::where('slug', $request->get('course'))->first() : null;

        $variables = collect([
            'type' => 'lessons',
            'title' => 'Preview',
            'size' => 'xl',
            'file' => 'backend.lessons.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'lesson', 'course'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Lesson $lesson)
    {
        $course = $request->get('course') ? Course::where('slug', $request->get('course'))->first() : null;

        $variables = collect([
            'type' => 'lessons',
            'title' => 'Edit',
            'file' => 'backend.lessons.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'lesson', 'course']))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request\UpdateLessonRequest  $request
     * @param  \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        try {
            DB::beginTransaction();
            $lesson->update($request->validated());
            if($request->hasFile('image')) {
                $lesson->image  = uploadOrUpdateFile($request->file('image'), $lesson->image, \constPath::LessonImage);
                $lesson->save();
            }
            DB::commit();
            LaravelFlash::withSuccess('Lesson Updated Successfully');
            return redirect()->route('lessons.index');

        } catch(\Throwable $th) {
            DB::rollBack();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson)
    {
        try {
            LaravelFlash::withInfo('Unable to process this action at the moment');
            return redirect()->back();

        } catch(\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
