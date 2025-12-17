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












    
}
