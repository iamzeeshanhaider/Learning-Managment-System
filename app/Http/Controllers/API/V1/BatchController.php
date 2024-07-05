<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\GeneralStatus;
use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\BatchResource;
use App\Models\Batch;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::where('status', GeneralStatus::Enabled)->get();
        return response()->json([
            'message' => 'Batches Retrived',
            'batches' => BatchResource::collection($batches),
        ]);
    }
}
