<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Provided_Service;
use App\Services\ProvidedServiceService;
use Illuminate\Http\Request;


class ProvidedServiceController extends Controller
{

    public $providedService ;


    public function __construct(ProvidedServiceService $providedService) {
       

        $this->providedService=$providedService ;


    }


    
    public function store(Request $request)
    {
        $service = $this->providedService->createService($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Service created successfully',
            'result' => new ServiceResource($service)
        ], 201);
        
    }


    public function index(Request $request)
{
    $services = $this->providedService->getAllServices($request->all());

    return response()->json([
        'status' => 'success',
        'message'=>"retrieving services successfully",
        'result' => ServiceResource::collection($services)
    ]);
}


public function getAllServicesNames()
{
    $services = $this->providedService->getAllServicesNames();

    return response()->json([
        'status' => 'success',
        'message'=>"retrieving services names successfully",
        'result' =>ServiceResource::collection($services)->map->onlyIdAndTitle()
    ]);
}

public function show($id)
{
    $service = $this->providedService->getServiceById($id);

    if (!$service) {
        return response()->json(['status'=>'error','message'=>'Service not found'],404);
    }

    return response()->json([
        'status'=>'success',
        'message'=>"retrieving service successfully",
        'result'=>new ServiceResource($service)
    ]);
}


public function update(Request $request, $id)
{
    $service = $this->providedService->updateService($id, $request->all());

    if (!$service) {
        return response()->json(['status'=>'error','message'=>'Service not found'],404);
    }

    return response()->json([
        'status'=>'success',
        'message'=>"update service successfully",
        'result'=>new ServiceResource($service)
    ]);
}

public function destroy($id)
{
    $deleted = $this->providedService->deleteService($id);

    if (!$deleted) {
        return response()->json([
        'status'=>'error',
        'message'=>'Service not found'],
        404);
    }

    return response()->json([
        'status'=>'success',
        'message'=>'Service deleted successfully'
    ]);
}











    
}
