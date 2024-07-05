<?php

namespace App\Http\Controllers;

use App\Models\{Course, CourseMaster, LessonFolder, LessonResource, Module};
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Repositories\V1\CertificateRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class CourseController extends Controller
{

    protected $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $courseMaster = $request->get('cm') ? CourseMaster::where('slug', $request->get('cm'))->first() : null;
        $module = $request->get('module') ? Module::where('slug', $request->get('module'))->first() : null;

        return view('jambasangsang.backend.courses.index', compact(['courseMaster', 'module']));
    }


    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function user_courses(Request $request)
    {
        $view = $request->get('view') === 'list' ? 'list' : 'grid';
        $order = $request->get('order_dir') === 'asc' ? 'asc' : 'desc';
        $courses = null;

        $student = auth()->user();

        if ($student->hasRole('Student')) {
            $query = $student->courses()->where(['batch_id' => getActiveBatch()->id]);

            $courses = $query->search($request->collect())
                ->with([
                    'quizzes',
                    'lessons',
                ])
                ->orderBy('id', $order)
                ->paginate(10, ['*'], 'user_courses')
                ->withQueryString();
        }

        return view('jambasangsang.backend.courses.listing', compact('view', 'courses'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Model\Course $course
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show_user_courses(Request $request, Course $course)
    {
        $view = $request->get('view') ?? 'lessons';
        $l_view = $request->get('l_view') ?? ''; // Lesson View
        $r_view = $request->get('r_view') ?? ''; // Resource View
        $student = auth()->user();
        $resources = $r_view ? LessonResource::where('folder_id', $r_view)->get() : null;
        $folder = $r_view ? LessonFolder::find($r_view) : null;
        $refresh = $request->get('refresh') ?? false;

        if ($student->hasRole('Student')) {
            $course = $student->courses()
                ->where([
                    'batch_id' => getActiveBatch()->id,
                    'course_id' => $course->id
                ])
                ->with([
                    'quizzes',
                    'lessons'
                ])
                ->first();

            $certificate = hasCertificate($student, $course) ? $this->certificateRepository->generateCertificate(true, $refresh, $student, $course) : null;
        }

        if ($refresh) {
            $request->query->remove('refresh');
            return redirect($request->fullUrlWithoutQuery('refresh'));
        } else {
            return view('jambasangsang.backend.courses.show', compact('course', 'view', 'certificate', 'l_view', 'resources', 'folder'));
        }
    }

    public function create(Request $request)
    {
        $courseMaster = $request->get('cm') ? CourseMaster::where('slug', $request->get('cm'))->first() : null;
        $module = $request->get('module') ? Module::where('slug', $request->get('module'))->first() : null;

        $variables = collect([
            'type' => 'course',
            'file' => 'backend.courses.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'courseMaster', 'module']))->render();
    }

    public function store(StoreCourseRequest $request)
    {
        Gate::authorize('add_courses');

        try {
            DB::beginTransaction();

            $course = Course::create($request->validated());

            if ($request->hasFile('image')) {
                $course->image  = uploadOrUpdateFile($request->file('image'), $course->image, \constPath::CourseImage);
                $course->save();
            }

            DB::commit();
            LaravelFlash::withSuccess('Course Created Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    public function show(Course $course)
    {
        $variables = collect([
            'type' => 'course',
            'title' => 'Preview',
            'size' => 'xl',
            'file' => 'backend.courses.partials.show'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'course']))->render();
    }

    public function edit(Course $course, Request $request)
    {
        $courseMaster = $request->get('cm') ? CourseMaster::where('slug', $request->get('cm'))->first() : null;
        $module = $request->get('module') ? Module::where('slug', $request->get('module'))->first() : null;

        $variables = collect([
            'type' => 'course',
            'title' => 'Edit',
            'file' => 'backend.courses.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'course', 'courseMaster', 'module']))->render();
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        try {
            DB::beginTransaction();

            $course->update($request->validated());
            if ($request->hasFile('image')) {
                $course->image  = uploadOrUpdateFile($request->file('image'), $course->image, \constPath::CourseImage);
                $course->save();
            }
            DB::commit();

            LaravelFlash::withSuccess('Course Updated Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    public function destroy(Course $course)
    {
        try {
            LaravelFlash::withInfo('Unable to process this action at the moment');
            return back();
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
