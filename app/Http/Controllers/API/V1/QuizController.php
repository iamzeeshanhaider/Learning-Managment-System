<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\QuizResource;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Quiz;
use App\Traits\TablePagination;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    use TablePagination;

    private $user;

    public function __construct()
    {
        $this->user = auth('api')->user();
    }

    private function checkEnrollment(Batch $batch, Course $course): void
    {
        $courseIds = $this->user->courses()->where('batch_id', $batch->id)->pluck('courses.id')->toArray();

        if (!in_array($course->id, $courseIds)) {
            throw new \Exception('You do not have access to this course', 422);
        }
    }

    public function index(Request $request, Batch $batch, Course $course): JsonResponse
    {
        try {
            $this->checkEnrollment($batch, $course);

            $order = $request->input('order_dir', 'desc');
            $per_page = $request->input('per_page', 10);

            $quizzes = $course->quizzes()
                ->forBatch($batch->id)
                ->orderBy('id', $order)
                ->paginate($per_page);

            $quiz_data = QuizResource::collection($quizzes);
            $paginationData = $this->paginate($quizzes);

            return response()->json([
                'message' => 'Quizzes Retrieved',
                'quizzes' => $quiz_data,
                'pagination' => $paginationData,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }

    public function show(Batch $batch, Course $course, Quiz $quiz): JsonResponse
    {
        try {
            $this->checkEnrollment($batch, $course);

            return response()->json([
                'message' => 'Quiz Retrieved',
                'quiz' => new QuizResource($quiz),
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        }
    }
}
