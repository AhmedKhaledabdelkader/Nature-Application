<?php

namespace App\Services;

use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Repositories\Eloquents\ClientRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ClientService
{

    public $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository,protected ImageConverterService $imageConverterService)
    {
        $this->clientRepository = $clientRepository;
        
    }

    public function createClient(array $data)
    {

           
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);  

    $data['name'] = [
       $locale => $data['name'] ?? null,
    ];

      if (!empty($data['logo'])) {

        $data['logo'] = $this->imageConverterService->convertAndStore($data['logo'], 'clients');
    }

        return $this->clientRepository->create($data);

    }



    public function updateClient(string $id, array $data)
{
    $client = $this->clientRepository->find($id);

    if (!$client) {
        return null;
    }

    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);

    // 📝 update localized name
    if (isset($data['name'])) {
        $client->setLocalizedValue('name', $locale, $data['name']);
    }

    // 🖼️ update logo
    if (!empty($data['logo'])) {

        // delete old logo
        if ($client->logo && Storage::disk('private')->exists($client->logo)) {
            Storage::disk('private')->delete($client->logo);
        }

        $client->logo = $this->imageConverterService
            ->convertAndStore($data['logo'], 'clients');
    }

    $client->save();

    return $client;
}



public function getAllClients(array $data){

 $size = $data['size'] ?? 10;
$page = $data['page'] ?? 1;


    return $this->clientRepository->getAll($page,$size) ;


}


public function deleteClient(string $id)
{
    $client = $this->clientRepository->find($id);
    
    if (!$client) {
        return false;
    }
    
    // Delete logo if exists
    if ($client->logo && Storage::disk('private')->exists($client->logo)) {
        Storage::disk('private')->delete($client->logo);
    }
    
    return $this->clientRepository->delete($id);
}










}
