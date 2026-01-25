<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\SimpleServiceResource;
use App\Services\ServiceV2Service;
use Illuminate\Http\Request;



class ServiceV2Controller extends Controller
{

    public $serviceV2Service ;


    public function __construct(ServiceV2Service $serviceV2Service) {
        $this->serviceV2Service = $serviceV2Service ;
    }



    public function store(Request $request){


        
     $service = $this->serviceV2Service->addService($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Service created successfully',
            'result' => new ServiceResource($service)
        ], 201);


    }


    
public function show($id)
{
    $service = $this->serviceV2Service->getServiceById($id);

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
    $service = $this->serviceV2Service->updateService($request->all(),$id);

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
    $deleted = $this->serviceV2Service->deleteService($id);

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




    public function index(Request $request)
{
    $services = $this->serviceV2Service->getAllServices($request->all());

    return response()->json([
        'status' => 'success',
        'message'=>"retrieving services successfully",
        'result' => SimpleServiceResource::collection($services)
    ]);
}



    public function indexSearchServices(Request $request)
{
    $services = $this->serviceV2Service->getAllSearchServices($request->all());

    return response()->json([
        'status' => 'success',
        'message'=>"retrieving published services successfully",
        'result' => SimpleServiceResource::collection($services)
    ]);
}



    public function indexPublishedServicesNames(Request $request)
{
    $services = $this->serviceV2Service->getAllServicesNames($request->all());

    return response()->json([
        'status' => 'success',
        'message'=>"retrieving services names successfully",
        'result' => SimpleServiceResource::collection($services)->map->onlyIdAndName()
    ]);
}







    
}
