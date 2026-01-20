<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    public $projectService ;

    public function __construct(ProjectService $projectService) {
    

        $this->projectService=$projectService ;


    }


    public function store(Request $request){


    $project=$this->projectService->createProject($request->all()) ;
         

    $project->load(['city', 'country','services']);

        return response()->json([
            'status' => 'success',
            'message' => 'project added successfully',
            'result' =>new ProjectResource($project),
 
        ], 200);


    }


     public function index(Request $request)
    {
        $projects = $this->projectService->getAllProjects($request->all());

          $projects->load(['city', 'country','services']);

        return response()->json([
            'status' => 'success',
            'message' => 'Projects retrieved successfully',
            'result' => ProjectResource::collection($projects),
            'meta' => [
                'current_page' => $projects->currentPage(),
                'per_page' => $projects->perPage(),
                'total' => $projects->total(),
                'last_page' => $projects->lastPage(),
            ]
        ]);
    }

    // Get single project by ID
    public function show(string $id)
    {
        $project = $this->projectService->getProjectById($id);

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }

         $project->load(['city', 'country','services']);


        return response()->json([
            'status' => 'success',
            'message' => 'Project retrieved successfully',
            'result' => new ProjectResource($project)
        ]);
    }

    // Update project
    public function update(Request $request, string $id)
    {
        $project = $this->projectService->updateProject($id, $request->all());

        if (!$project) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }

        $project->load(['city', 'country','services']);

        return response()->json([
            'status' => 'success',
            'message' => 'Project updated successfully',
            'result' => new ProjectResource($project)
        ]);
    }

    // Delete project
    public function destroy(string $id)
    {
        $deleted = $this->projectService->deleteProject($id);

        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Project not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully'
        ]);
    }

    






    
}
