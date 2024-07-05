<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreModuleRequest;
use App\Http\Requests\UpdateModuleRequest;
use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jambasangsang.backend.modules.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variables = collect([
            'type' => 'modules',
            'file' => 'backend.modules.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreModuleRequest $request)
    {
        try {
            DB::beginTransaction();

            $module = Module::create($request->validated());
            if($request->hasFile('image')) {
                $module->image  = uploadOrUpdateFile($request->file('image'), $module->image, \constPath::ModuleImage);
                $module->save();
            }

            DB::commit();

            LaravelFlash::withSuccess('Module Created Successfully');

            return back();
        } catch(\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  module
     * @return \Illuminate\Http\Response
     */
    public function show(Module $module)
    {
        $variables = collect([
            'type' => 'modules',
            'title' => 'View',
            'file' => 'backend.modules.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'module'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module)
    {
        $variables = collect([
            'type' => 'modules',
            'title' => 'Edit',
            'file' => 'backend.modules.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'module'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  module
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateModuleRequest $request, Module $module)
    {
        try {
            DB::beginTransaction();

            $module->update($request->validated());
            if($request->hasFile('image')) {
                $module->image  = uploadOrUpdateFile($request->file('image'), $module->image, \constPath::ModuleImage);
                $module->save();
            }

            DB::commit();

            LaravelFlash::withSuccess('Module Updated Successfully');

            return back();
        } catch(\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module)
    {
        try {
            if(count($module->courses)) {
                LaravelFlash::withInfo('This Module has data attached to it and cannot be deleted');
                return redirect()->back();
            } else {
                $module->delete();

                LaravelFlash::withSuccess('Operation Successful');
                return redirect()->back();
            }

        } catch(\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }
}
