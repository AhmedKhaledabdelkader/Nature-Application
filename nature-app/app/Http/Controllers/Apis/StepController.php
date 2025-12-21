<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\StepResource;
use App\Models\Provided_Service;
use App\Services\StepService;
use Illuminate\Http\Request;



class StepController extends Controller
{
    

    public $stepService ;


    public function __construct(StepService $stepService) {


        $this->stepService=$stepService ;
       
    }


    public function store(Request $request, Provided_Service $service)
    {


        $my_service = $this->stepService->addStepToService(
            $service,
            $request->all()
        );


        $my_service->load('steps');

        return response()->json([
            'status' => 'success',
            'message' => 'Step added to service successfully',
            'result' => new ServiceResource($my_service)
        ], 201);
    }





        public function update(Request $request) {


        $updatedStep = $this->stepService->updateStep($request->all());

        if (!$updatedStep) {
            return response()->json([
                'status'=>'error',
                'message' => 'Service or Step not found',
            ], 404);
        }

        return response()->json([
             'status'=>'success',
            'result' => new StepResource($updatedStep),
        ]);
    }
    

    
public function destroy(Request $request) {
        $deleted = $this->stepService->deleteStep($request->all());

        if (!$deleted) {
            return response()->json([
                'status'=>'error',
                'message' => 'Service or Step not found',
            ], 404);
        }

        return response()->json([
            'status'=>'success',
            'message' => 'Step deleted successfully',
        ]);
    }





}
