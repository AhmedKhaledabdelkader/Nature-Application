<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\Request;



class ClientController extends Controller
{

    public $clientService ;


    public function __construct(ClientService $clientService) {

        $this->clientService=$clientService ;
        
    }

     public function store(Request $request)
    {
        $client = $this->clientService->createClient($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Client created successfully',
            'result' => new ClientResource($client)
        ], 201);
        
    }



 
    public function update(Request $request, string $id)
    {
        $client = $this->clientService->updateClient($id, $request->all());

        if (!$client) {
            return response()->json([
                'status' => 'error',
                'message' =>'Client not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Client updated successfully',
            'result' => new ClientResource($client)
        ]);
    }






public function index(Request $request)
    {
        $data=$request->all();
        $clients = $this->clientService->getAllClients($data);
        return response()->json([
            'status' => 'success',
            'message' => 'clients retrieved successfully',
            'result' => ClientResource::collection($clients),
       /*     'meta' => [
            'current_page' => $clients->currentPage(),
            'per_page' => $clients->perPage(),
            'total' => $clients->total(),
            'last_page' => $clients->lastPage(),
        ]*/

        ], 200);
    }



      public function destroy(string $id)
{
    
        $deleted = $this->clientService->deleteClient($id);
        
        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => 'Client not found'
            ], 404);
        }
        
        return response()->json([
            'success' => 'success',
            'message' => 'Client deleted successfully'
        ]);
    
}








    
}
