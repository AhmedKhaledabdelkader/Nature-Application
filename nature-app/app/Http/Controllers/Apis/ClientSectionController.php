<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Services\ClientSectionService;
use Illuminate\Http\Request;

class ClientSectionController extends Controller
{


    
    public $clientSectionService ;


    public function __construct(ClientSectionService $clientSectionService) {

        $this->clientSectionService=$clientSectionService ;
        
    }


    public function store(Request $request){



        $clientSection = $this->clientSectionService->addClientSection($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Client created successfully',
            'result' => (new ClientResource($clientSection))->allData()
        ], 201);

    }

public function update(string $id,Request $request){

    $clientSection = $this->clientSectionService->updateClient($id,$request->all());

    if (!$clientSection) {
        return response()->json([
            'status' => 'error',
            'message' => 'Client not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Client updated successfully',
        'result' =>(new ClientResource($clientSection))->allData()
    ], 200);



}


public function index(Request $request){

    $clients = $this->clientSectionService->getAllClientSections($request->all());

    

    return response()->json([
        'status' => 'success',
        'message' => 'Clients retrieved successfully',
        'result' =>  ClientResource::collection($clients),
        'page' => $clients->currentPage(),
        'size' => $clients->perPage(),
        'total' => $clients->total(),
        'lastPage' => $clients->lastPage(),
            ]
    , 200);

    
}



public function show(Request $request,string $id){

    $client = $this->clientSectionService->findClient($id);


    if (!$client) {
        return response()->json([
            'status' => 'error',
            'message' => 'Client not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Client retrieved successfully',
        'result' => (new ClientResource($client))->allData()
    ], 200);

    
}

public function search(Request $request){

    $clients = $this->clientSectionService->searchClientSections($request->all());

    return response()->json([
        'status' => 'success',
        'message' => 'Clients retrieved successfully',
        'result' =>  ClientResource::collection($clients),
         'page' => $clients->currentPage(),
        'size' => $clients->perPage(),
        'total' => $clients->total(),
        'lastPage' => $clients->lastPage(),
    ], 200);

    
}



public function destroy(string $id)
{
    
        $deleted = $this->clientSectionService->deleteClient($id);
        
        if (!$deleted) {
            return response()->json([

                'status' => 'error',
                'message' => 'Client not found'

            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Client deleted successfully'
        ]);
    
}









}