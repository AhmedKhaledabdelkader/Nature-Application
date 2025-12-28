<?php

namespace App\Services;

use App\Repositories\Contracts\ClientRepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class ClientService
{

    
    use HandlesFileUpload,HandlesLocalization,LocalizesData ;

    public $clientRepository;

    public function __construct(ClientRepositoryInterface $clientRepository,protected ImageConverterService $imageConverterService)
    {
        $this->clientRepository = $clientRepository;
        
    }

    public function createClient(array $data)
    {

     $locale = app()->getLocale();
  
    $this->localizeFields($data,['name'],$locale);

    $data["logo"] = $this->uploadFile($data['logo'] ?? null, 'clients', $this->imageConverterService);
    
    return $this->clientRepository->create($data);

    }



    public function updateClient(string $id, array $data)

{

    $locale = app()->getLocale();

    $client = $this->clientRepository->find($id);

    if (!$client) {
        return null;
    }

    $this->setLocalizedFields($client, $data, ['name'],$locale);

    $client->logo = $this->updateFile($data['logo']??null,$client->logo,'clients',$this->imageConverterService);

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
    
    $this->deleteFile($client->logo);
    
    return $this->clientRepository->delete($id);
}





}
