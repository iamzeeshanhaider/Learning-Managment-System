<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Jambasangsang\Flash\Facades\LaravelFlash;

class CategoryController extends Controller
{

    public function index()
    {
        return view('jambasangsang.backend.categories.index');
    }

    public function create()
    {
        $variables = collect([
            'type' => 'category',
            'file' => 'backend.categories.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables'))->render();
    }


    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();

            Category::create($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Category Created Successfully');

            return back();
        } catch(\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }


    public function show(Category $category)
    {
        $variables = collect([
            'type' => 'category',
            'title' => 'View',
            'file' => 'backend.categories.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'category'))->render();
    }


    public function edit(Category $category)
    {
        $variables = collect([
            'type' => 'category',
            'title' => 'Edit',
            'file' => 'backend.categories.partials.field'
        ]);

        return view('components.partials.general-modal', compact('variables', 'category'))->render();
    }


    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::beginTransaction();

            $category->update($request->validated());

            DB::commit();

            LaravelFlash::withSuccess('Category Updated Successfully');

            return redirect()->back();
        } catch(\Throwable $th) {
            DB::rollback();

            LaravelFlash::withError($th->getMessage());

            return back();
        }
    }
}
