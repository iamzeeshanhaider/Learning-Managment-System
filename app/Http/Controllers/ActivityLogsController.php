<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;

class ActivityLogsController extends Controller
{

    public function index()
    {
        return view('jambasangsang.backend.activity_logs.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Model\ActivityLog  $logs
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityLog $log)
    {
        // dd($log);
        $variables = collect([
            'type' => 'logs',
            'title' => 'View',
            'size' => 'xl',
            'file' => 'backend.activity_logs.partials.show'
        ]);

        return view('components.partials.general-modal', compact('variables', 'log'))->render();
    }


}
