<?php

namespace App\Http\Controllers;

use App\Enums\GeneralStatus;
use Illuminate\Http\Request;
use App\Models\TicketCategory;
use BenSampo\Enum\Rules\EnumValue;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class TicketCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('jambasangsang.backend.support.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ticket_category = null;
        $variables = collect([
            'type' => 'ticket_category',
            'file' => 'backend.support.category.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'ticket_category']))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:ticket_categories,name',
            'status' => ['nullable', new EnumValue(GeneralStatus::class)],
        ]);

        try {
            DB::beginTransaction();

            TicketCategory::create($validatedData);

            DB::commit();
            LaravelFlash::withSuccess('Ticket Category Created Successfully');
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
     * @param  TicketCategory $ticket_category
     */
    public function show(Request $request, TicketCategory $ticket_category)
    {
        $variables = collect([
            'type' => 'ticket_category',
            'title' => 'Preview',
            'file' => 'backend.support.category.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'ticket_category'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  TicketCategory $ticket_category
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketCategory $ticket_category)
    {
        $variables = collect([
            'type' => 'ticket_category',
            'file' => 'backend.support.category.partials.field'
        ]);

        return view('components.partials.general-modal', compact(['variables', 'ticket_category']))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketCategory $ticket_category)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:ticket_categories,name,' . $ticket_category->id,
            'status' => ['nullable', new EnumValue(GeneralStatus::class)],
        ]);

        try {
            DB::beginTransaction();

            $ticket_category->update($validatedData);

            DB::commit();
            LaravelFlash::withSuccess('Ticket Category Updated Successfully');
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
     * @param  TicketCategory $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketCategory $ticket_category)
    {
        if ($ticket_category->tickets->isNotEmpty()) {
            LaravelFlash::withInfo('Unable to process this action at the moment. There are associated tickets.');
        } else {
            $ticket_category->delete();
            LaravelFlash::withSuccess('Operation Successful. Ticket Category deleted.');
        }

        return redirect()->back();
    }
}
