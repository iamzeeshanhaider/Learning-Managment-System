<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\V1\TicketCategoryResource;
use App\Models\TicketCategory;
use App\Traits\TablePagination;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class TicketCategoryController extends Controller
{
    use TablePagination;

    public function index(Request $request)
    {
        $order = $request->input('order_dir', 'desc');

        try {
            $category_data = TicketCategory::latest()->orderBy('id', $order)->paginate();
            $paginationData = $this->paginate($category_data);

            $categories = TicketCategoryResource::collection($category_data);
            $paginationData = $this->paginate($category_data);

            return response()->json([
                'message' => 'Ticket Categories Retrieved',
                'categories' => $categories,
                'pagination' => $paginationData,
            ]);

        } catch (JWTException $th) {
            return response()->json(['error' => $th->getMessage()], 422);
        }
    }

}
