<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\CourseResource;
use App\Models\Batch;
use App\Traits\TablePagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class CourseController extends Controller
{
    use TablePagination;

    public function student_courses(Request $request, Batch $batch): JsonResponse
    {
        $order = $request->input('order_dir', 'desc');
        $per_page = $request->input('per_page', 10);

        $user = auth('api')->user();

        if (!$user->isStudent()) {
            return response()->json('This is a student route', 422);
        }

        try {
            $courses = $user->courses()
                ->where('batch_id', $batch->id)
                ->with([
                    'quizzes' => fn ($q) => $q->forBatch($batch->id),
                    'lessons.folders.resources'
                ])
                ->orderBy('id', $order)
                ->paginate($per_page);

            $courseResource = CourseResource::collection($courses);
            $paginationData = $this->paginate($courses);

            return response()->json([
                'message' => 'Courses Retrieved',
                'courses' => $courseResource,
                'pagination' => $paginationData,
            ]);

        } catch (JWTException $th) {
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }
}
