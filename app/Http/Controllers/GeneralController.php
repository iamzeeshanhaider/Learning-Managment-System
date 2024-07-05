<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class GeneralController extends Controller
{

    public function get_courses(Request $request): Collection
    {
        $query = Course::query()->search($request->collect())->paginate($request->get('per_page', 10));
        return collect(['courses' => $query]);
    }

    public function get_batches(Request $request): Collection
    {
        $query = Batch::query()->search($request->collect())->paginate($request->get('per_page', 10));
        return collect(['batches' => $query]);
    }

    public function init_calendar(Request $request)
    {
        return view('jambasangsang.backend.general.calendar.index');
    }

    public function init_sessions(Request $request)
    {
        return view('jambasangsang.backend.general.calendar.sessions');
    }

}
