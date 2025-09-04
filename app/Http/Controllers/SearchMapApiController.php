<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchMapApiController extends Controller
{
    /**
     * Method for Rest API to get cities by name, at least 3 characters.
     * 
     * @param string $alias - city alias
     * 
     * @return JsonResponse
     */
    public function searchByCityName(string $alias): JsonResponse
    {
        if(strlen($alias) < 3) {
            return response()->json([
                "success" => false,
                "message" => "City name must be at least 3 characters long"
            ], 400);
        }

        $cities = DB::table('cities')
        ->whereRaw("LOWER(cities.name) LIKE ?", [strtolower($alias) . "%"])
        ->get();

        return response()->json([
            "success" => true,
            "message" => "Success",
            "response" => $cities
        ], 200);
    }
}
