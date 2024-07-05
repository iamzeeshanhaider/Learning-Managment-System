<?php

namespace App\Http\Controllers\API\V1;

use App\Enums\Ethnicity;
use App\Enums\Gender;
use App\Enums\UKStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function getGender()
    {
        try {
            $data = Gender::getInstances();
            return response()->json([
                'message' => 'Gender List Retrived',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function getEthnicity()
    {
        try {
            $data = Ethnicity::getInstances();
            return response()->json([
                'message' => 'Ethnicity List Retrived',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function getUKStatus()
    {
        try {
            $data = UKStatus::getInstances();
            return response()->json([
                'message' => 'UK-Status List Retrived',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

}
