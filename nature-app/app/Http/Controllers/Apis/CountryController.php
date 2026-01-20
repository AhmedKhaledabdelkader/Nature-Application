<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Services\CountryService;
use Illuminate\Http\Request;




class CountryController extends Controller
{

    public $countryService;

public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    
}

public function store(Request $request)
    {
        $country = $this->countryService->createCountry($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Country created successfully',
            'result' => new CountryResource($country)
        ], 201);
        
    }


public function show(string $id)
    {

    $country = $this->countryService->getCountryById($id);

       
        if (!$country) {
            return response()->json([
                'status' => 'error',
                'message' => 'Country not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Country retrieved successfully',
            'result' => new CountryResource($country)
        ], 200);
    
}












public function index(Request $request)
    {
        $data=$request->all();
        $countries = $this->countryService->getAllCountries($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Countries retrieved successfully',
            'result' => CountryResource::collection($countries),
 
        ], 200);
    }



public function update(Request $request, string $id)
    {

        $country = $this->countryService->updateCountry($id, $request->all());

        if ($country==null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Country not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Country updated successfully',
            'result' => new CountryResource($country)
        ], 200);


    
    }


    public function destroy(string $id)
{
    
        $deleted = $this->countryService->deleteCountry($id);
        
        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Country not found'
            ], 404);
        }
        
        return response()->json([
            'success' => 'success',
            'message' => 'Country deleted successfully'
        ]);
    
}
















    
}
