<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Services\CityService;
use Illuminate\Http\Request;


class CityController extends Controller
{

    public $cityService;

    public function __construct(CityService $cityService) {
        
        $this->cityService = $cityService;
    }



    public function store(Request $request)
    {
        $city = $this->cityService->createCity($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'City created successfully',
            'result' => new CityResource($city)
        ], 201);
        
    }


     public function index(Request $request, string $countryId)
    {
        $cities = $this->cityService->getCitiesByCountry($countryId, $request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Cities retrieved successfully',
            'result' => CityResource::collection($cities)
        ]);
    }

    public function show(string $id)
    {
        $city = $this->cityService->getCityById($id);

        if (!$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'City not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'City retrieved successfully',
            'result' => new CityResource($city)
        ]);
    }

    public function update(Request $request, string $id)
    {
        $city = $this->cityService->updateCity($id, $request->all());

        if (!$city) {
            return response()->json([
                'status' => 'error',
                'message' => 'City not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'City updated successfully',
            'result' => new CityResource($city)
        ]);
    }

    public function destroy(string $id)
    {
        $deleted = $this->cityService->deleteCity($id);

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'City not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'City deleted successfully'
        ]);
    }
}





