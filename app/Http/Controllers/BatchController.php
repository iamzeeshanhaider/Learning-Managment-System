<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBatchRequest;
use App\Http\Requests\UpdateBatchRequest;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jambasangsang.backend.batches.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $variables = collect([
            'type' => 'batch',
            'file' => 'backend.batches.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBatchRequest $request)
    {
        try {
            DB::beginTransaction();

            Batch::create($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Batch Created Successfully');

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
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function show(Batch $batch)
    {
        return view('jambasangsang.backend.batches.show', compact('batch'));

        // $variables = collect([
        //     'type' => 'batch',
        //     'title' => 'View',
        //     'file' => 'backend.batches.partials.show'
        // ]);

        // return view('components.partials.general-modal', compact('variables', 'batch'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function edit(Batch $batch)
    {
        $variables = collect([
            'type' => 'batch',
            'title' => 'Edit',
            'file' => 'backend.batches.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'batch'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Batch  $batch
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBatchRequest $request, Batch $batch)
    {
        try {
            DB::beginTransaction();

            $batch->update($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Batch Updated Successfully');

            return redirect()->back();
        } catch(\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }
}
