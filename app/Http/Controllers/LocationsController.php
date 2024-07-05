<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class LocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jambasangsang.backend.locations.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variables = collect([
            'type' => 'locations',
            'file' => 'backend.locations.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLocationRequest $request)
    {
         try {
            DB::beginTransaction();

            Location::create($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Location Created Successfully');

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
     * @param  \App\Models\ModLocationule  location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        $variables = collect([
            'type' => 'locations',
            'title' => 'View',
            'file' => 'backend.locations.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'location'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $variables = collect([
            'type' => 'locations',
            'title' => 'Edit',
            'file' => 'backend.locations.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'location'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        try {
            DB::beginTransaction();

            $location->update($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Location Updated Successfully');

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
     * @param  \App\Models\Location $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        try {
            if(count($location->courses)) {
                LaravelFlash::withInfo('This Location has data attached to it and cannot be deleted');
                return redirect()->back();
            } else {
                $location->delete();

                LaravelFlash::withSuccess('Operation Successful');
                return redirect()->back();
            }

        } catch(\Throwable $th) {
            LaravelFlash::withError($th->getMessage());
            return redirect()->back();
        }
    }
}
