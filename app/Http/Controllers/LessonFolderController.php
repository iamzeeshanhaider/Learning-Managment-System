<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\UpdateFolderRequest;
use App\Models\Lesson;
use App\Models\LessonFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class LessonFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Lesson $lesson)
    {
        $order = $request->get('order_dir') === 'asc' ? 'asc' : 'desc';
        $per_page = $request->get('per_page') ?? 11;

        $resource_not_in_folder = $lesson->resources()->where('folder_id', null)->exists();

        $folders = LessonFolder::where('lesson_id', $lesson->id)
                            ->search($request->collect())
                            ->orderBy('id', $order)
                            ->latest()
                            ->paginate($per_page, ['*'], 'lesson_folders')
                            ->withQueryString();

        return view('jambasangsang.backend.lessons.folders.index', compact(['lesson', 'folders', 'resource_not_in_folder']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Lesson $lesson)
    {
        $variables = collect([
            'type' => 'folder',
            'file' => 'backend.lessons.folders.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'lesson'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @param  \App\Http\Requests\StoreFolderRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFolderRequest $request, Lesson $lesson)
    {
        try {
            DB::beginTransaction();

            $lesson->folders()->create(array_merge(
                $request->validated(),
                [
                    'is_published' => $request->get('is_published') ? true : false
                ]
            ));

            DB::commit();
            LaravelFlash::withSuccess('Folder Created Successfully');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\LessonFolder  $folder
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Lesson $lesson, LessonFolder $folder)
    {
        $variables = collect([
            'type' => 'folder',
            'title' => 'Edit',
            'file' => 'backend.lessons.folders.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'lesson', 'folder'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFolderRequest  $request
     * @param  \App\Models\LessonFolder  $folder
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFolderRequest $request, Lesson $lesson, LessonFolder $folder)
    {
        try {
            DB::beginTransaction();

            $folder->update(array_merge(
                $request->validated(),
                ['is_published' => $request->get('is_published') ? true : false]
            ));
            DB::commit();

            LaravelFlash::withSuccess('Folder Updated Successfully');
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
     * @param  \App\Models\LessonFolder  $folder
     * @return \Illuminate\Http\Response
     */
    public function destroy(Lesson $lesson, LessonFolder $folder)
    {
        try {
            DB::beginTransaction();

            // $lesson->folders->detach($folder);

            // Soft Delete the LessonFolder itself
            $folder->delete();

            DB::commit();

            LaravelFlash::withSuccess('Folder and associated resources archived successfully');
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
     * @param  \App\Models\Lesson $lesson
     * @param  \App\Models\LessonFolder $folder
     * @return \Illuminate\Http\Response
     */
    public function duplicate_folder(Lesson $lesson, LessonFolder $folder)
    {
        try {
            DB::beginTransaction();
            // Create a duplicate of the original folder
            $newFolder = $folder->replicate();
            $newFolder->name = $folder->name;
            $newFolder->is_published = false;
            $newFolder->save();

            // Duplicate resources and associate them with the new folder
            $folder->resources->each(function ($resource) use ($newFolder) {
                $newFolder->resources()->create($resource->toArray());
            });

            DB::commit();

            LaravelFlash::withSuccess('Operation Successful');
            return redirect()->back();
        } catch (\Throwable $th) {
            DB::rollBack();
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }
}
