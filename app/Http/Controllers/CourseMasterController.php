<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCourseMasterRequest;
use App\Http\Requests\UpdateCourseMasterRequest;
use App\Models\Category;
use App\Models\CourseMaster;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class CourseMasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = $request->get('category') ? Category::where('slug', $request->get('category'))->first() : null;

        return view('jambasangsang.backend.course_master.index', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = $request->get('category') ? Category::where('slug', $request->get('category'))->first() : null;

        $variables = collect([
            'type' => 'course_master',
            'file' => 'backend.course_master.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'category']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCourseMasterRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            CourseMaster::create($request->validated());
            DB::commit();

            LaravelFlash::withSuccess('Course Master Created Successfully');
            return back();
        } catch(\Throwable $th) {
            DB::rollBack();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function show(CourseMaster $courseMaster)
    {
        $variables = collect([
            'type' => 'course_master',
            'title' => 'View',
            'file' => 'backend.course_master.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'courseMaster'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function edit(CourseMaster $courseMaster, Request $request)
    {

        $category = $request->get('category') ? Category::where('slug', $request->get('category'))->first() : null;

        $variables = collect([
            'type' => 'course_master',
            'file' => 'backend.course_master.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'category']))->render();

        $variables = collect([
            'type' => 'course_master',
            'title' => 'Edit',
            'file' => 'backend.course_master.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'courseMaster', 'category'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CourseMaster  $courseMaster
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCourseMasterRequest $request, CourseMaster $courseMaster)
    {
        try {
            DB::beginTransaction();

            $courseMaster->update($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Category Master Updated Successfully');
            return back();
        } catch(\Throwable $th) {
            DB::roll();
            LaravelFlash::withError($th->getMessage());
            return back();
        }
    }
}
