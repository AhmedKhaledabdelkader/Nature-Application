<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\SponsorResource;
use App\Services\SponsorService;
use Illuminate\Http\Request;



class SponsorController extends Controller
{


    public $sponsorService;

    public function __construct(SponsorService $sponsorService)
    {
        $this->sponsorService = $sponsorService;
    }


    public function store(Request $request)
    {
        $sponsor = $this->sponsorService->createSponsor($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Sponsor created successfully',
            'result' => new SponsorResource($sponsor)
        ], 201);
        
    }

    
    public function update(Request $request, string $id)
    {
        $sponsor = $this->sponsorService->updateSponsor($id, $request->all());

        if (!$sponsor) {
            return response()->json([
                'status' => 'error',
                'message' =>'Sponsor not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Sponsor updated successfully',
            'result' => new SponsorResource($sponsor)
        ]);
    }




public function index(Request $request)
    {
       
        $clients = $this->sponsorService->getAllSponsors($request->all());
        return response()->json([
            'status' => 'success',
            'message' => 'sponsors retrieved successfully',
            'result' => SponsorResource::collection($clients),
       

        ], 200);
    }



  public function destroy(string $id)
{
    
        $deleted = $this->sponsorService->deleteSponsor($id);
        
        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sponsor not found'
            ], 404);
        }
        
        return response()->json([
            'success' => 'success',
            'message' => 'Sponsor deleted successfully'
        ]);
    
}











    
}
