<?php

namespace App\Http\Controllers;

use App\Enums\LessonResourceType;
use App\Http\Requests\{StoreLessonResourceRequest, UpdateLessonResourceRequest};
use App\Models\{Lesson, LessonFolder, LessonResource};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class LessonResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lesson $lesson, LessonFolder $folder)
    {
        return view('jambasangsang.backend.lessons.resources.index', compact(['lesson', 'folder']));
    }

    /**
     * Display a listing of the resource not in a folder.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @return \Illuminate\Http\Response
     */
    public function unlisted_resources(Request $request, Lesson $lesson)
    {
        $folder = null;
        return view('jambasangsang.backend.lessons.resources.index', compact(['lesson', 'folder']));
    }

    /**
     * Add resource to folder.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @return \Illuminate\Http\Response
     */
    public function init_add_to_folder(Request $request, Lesson $lesson, LessonFolder $folder, LessonResource $resource)
    {
        $variables = collect([
            'type' => 'lesson_resource',
            'file' => 'backend.lessons.resources.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'lesson', 'resource']))->render();

    }

    public function add_to_folder(Request $request, Lesson $lesson, LessonResource $resource)
    {
        try {
            $resource->update(['folder_id' => $request->get('folder_id')]);

            LaravelFlash::withSuccess('Operation Successful');
            return redirect()->back();
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Lesson $lesson, LessonFolder $folder)
    {
        $variables = collect([
            'type' => 'lesson_resource',
            'file' => 'backend.lessons.resources.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'lesson', 'folder']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @param  \Illuminate\Http\Request\StoreLessonResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLessonResourceRequest $request, Lesson $lesson, LessonFolder $folder)
    {
        try {
            DB::beginTransaction();

            $resource = LessonResource::create(array_merge($request->validated(), ['lesson_id' => $lesson->id, 'folder_id' => $folder->id]));

            if ($request->type === LessonResourceType::File && $request->hasFile('file')) {
                static::handleFile($request, $resource);
            }

            DB::commit();
            LaravelFlash::withSuccess('Lesson Resource Created Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @param  \App\Models\LessonResource $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Lesson $lesson, LessonFolder $folder, LessonResource $resource)
    {
        $variables = collect([
            'type' => 'lesson_resource',
            'title' => 'Preview',
            'size' => in_array($resource->extention, ['mp4', 'webm', 'mkv', '3gp', 'pdf']) ? 'xl' : 'lg',
            'padding' => '0',
            'file' => 'backend.lessons.resources.partials.show'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'lesson', 'folder', 'resource']))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @param  \App\Models\LessonResource $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson, LessonFolder $folder, LessonResource $resource)
    {
        if (!$lesson) LaravelFlash::withInfo('Invalid Lesson');

        $variables = collect([
            'type' => 'lesson_resource',
            'title' => 'Edit',
            'file' => 'backend.lessons.resources.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'lesson', 'folder', 'resource']))->render();
    }

    /**
     * Update a newly created resource in storage.
     *
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @param  \Illuminate\Http\Request\LessonResource $resource
     * @param  \Illuminate\Http\Request\UpdateLessonResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLessonResourceRequest $request, Lesson $lesson, LessonFolder $folder, LessonResource $resource)
    {
        try {
            if (!$lesson) LaravelFlash::withSuccess('Invalid Lesson');

            DB::beginTransaction();

            $resource->update($request->validated());

            if ($request->type === LessonResourceType::File && $request->hasFile('file')) {
                static::handleFile($request, $resource);
            }

            if ($resource->type !== LessonResourceType::URL && $resource->url) {
                $resource->update(['url' => null]);
            }

            if ($resource->type !== LessonResourceType::File && $resource->file) {
                $resource->update([
                    'extension' => null,
                    'file' => null
                ]);
            }

            if ($resource->type !== LessonResourceType::Embed && $resource->embed) {
                $resource->update(['embed' => null]);
            }

            DB::commit();
            LaravelFlash::withSuccess('Lesson Resource Updated Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson lesson
     * @param  \App\Models\LessonFolder $folder
     * @param  \App\Models\LessonResource resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, LessonFolder $folder, LessonResource $resource)
    {
        try {
            dd($resource);
            // $lesson->resources()->detach($resource);
            // $folder->resources()->detach($resource);
            $resource->delete();

            LaravelFlash::withSuccess('Operation Successful');
            return redirect()->back();
        } catch (\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LessonResource resource
     */
    public static function handleFile($request, LessonResource $resource): void
    {
        $resource->extention = $request->file('file')->getClientOriginalExtension() ?? '';
        $resource->file  = uploadOrUpdateFile($request->file('file'), $resource->file, \constPath::LessonResource);
        $resource->save();
    }
}
