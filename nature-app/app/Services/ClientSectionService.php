<?php

namespace App\Services;

use App\Repositories\Contracts\ClientSectionRepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesUnlocalized;

class ClientSectionService
{


    use HandlesFileUpload,HandlesUnlocalized ;

    public $clientSectionRepository;
    
    public function __construct(ClientSectionRepositoryInterface $clientSectionRepository,protected ImageConverterService $imageConverterService)
    {
        $this->clientSectionRepository = $clientSectionRepository;
    }
  

    public function addClientSection(array $data){



   $data["image"] = $this->uploadFile($data['image'] ?? null, 'clientSections', $this->imageConverterService);

    return $this->clientSectionRepository->create($data);


    }

     public function updateClient(string $id, array $data)

{

    $client = $this->clientSectionRepository->find($id);

    if (!$client) {
        return null;
    }

    $this->setUnlocalizedFields($client, $data, ['name_en','name_ar','status']);
   
    $client->image=$this->updateFile($data['image']??null,$client->image,'clientSections',$this->imageConverterService);
    
    $client->save();

    return $client;
}



public function getAllClientSections(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;

    return $this->clientSectionRepository->getAll($page, $size);



}

public function searchClientSections(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;
    $keyword = $data['keyword'] ?? '';

    return $this->clientSectionRepository->search($keyword, $page, $size);


}


public function deleteClientSection(string $id)
{
    return $this->clientSectionRepository->delete($id);


}




public function deleteClient(string $id)
{
    $client = $this->clientSectionRepository->find($id);
    
    if (!$client) {
        return false;
    }
    
    $this->deleteFile($client->image);
    
    return $this->clientSectionRepository->delete($id);
}



public function findClient(string $id){



    return $this->clientSectionRepository->find($id);



}





}