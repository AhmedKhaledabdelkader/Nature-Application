<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\AwardResource;
use App\Services\AwardService;
use Illuminate\Http\Request;

class AwardController extends Controller
{

    public $awardService ;

    public function __construct(AwardService $awardService)
    {
        $this->awardService = $awardService ;
    }


    public function store(Request $request)
    {
        $award = $this->awardService->createAward($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Award created successfully',
            'result' => new AwardResource($award)
        ], 201);

        
    }


    public function update(Request $request, string $id)
    {

        $country = $this->awardService->updateAward($id, $request->all());

        if ($country==null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Award not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Award updated successfully',
            'result' => new AwardResource($country)
        ], 200);


    
    }

    public function index(Request $request)
    {
        $awards = $this->awardService->getAllAwards($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Awards retrieved successfully',
            'result' => AwardResource::collection($awards)
        ], 200);
    }













    
}
