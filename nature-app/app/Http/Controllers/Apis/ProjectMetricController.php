<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectMetricResource;
use App\Services\ProjectMetricService;
use Illuminate\Http\Request;





class ProjectMetricController extends Controller
{


    public $projectMetricService;


    public function __construct( ProjectMetricService $projectMetricService)
    {
        $this->projectMetricService = $projectMetricService;
    }


    public function store(Request $request)
    {
        

        $projectMetric = $this->projectMetricService->createProjectMetric($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Project metric created successfully',
            'result' => new ProjectMetricResource($projectMetric),
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $projectMetric = $this->projectMetricService->updateProjectMetric($id, $request->all());

        if (!$projectMetric) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project metric not found',
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Project metric updated successfully',
            'result' => new ProjectMetricResource($projectMetric),
        ], 200);
    }








    
}
