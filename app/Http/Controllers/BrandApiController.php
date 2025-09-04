<?php
namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\BrandService;

class BrandApiController extends Controller {
    /**
     * Method for Rest API to get all active brands.
     * 
     * @return JsonResponse
     */
    public function getAll(BrandService $brandService): JsonResponse {
        return response()->json(
        [
            "success" => true,
            "message" => "Success",
            "response" => $brandService->getAllActive()
        ]);
    }
}