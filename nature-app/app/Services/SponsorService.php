<?php

namespace App\Services;

use App\Repositories\Contracts\SponsorRepositoryInterface;
use App\Repositories\Eloquents\SponsorRepository;
use App\Traits\HandlesFileUpload;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class SponsorService
{

    use HandlesFileUpload ;
    public $sponsorRepository;

    public function __construct(SponsorRepositoryInterface $sponsorRepository,protected ImageConverterService $imageConverterService)
    {
        $this->sponsorRepository = $sponsorRepository;
    }


    public function createSponsor(array $data) 
    
    {

        
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);   
    $data['name'] = [
       $locale => $data['name'] ?? null,
    ];

     
    $data["logo"] = $this->uploadFile($data['logo'] ?? null, 'sponsors', $this->imageConverterService);
    

    return $this->sponsorRepository->create($data);

        
    }


    public function updateSponsor(string $id, array $data)
{
    $sponsor = $this->sponsorRepository->find($id);

    if (!$sponsor) {
        return null;
    }

    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);
    
    if (isset($data['name'])) {
        $sponsor->setLocalizedValue('name', $locale, $data['name']);
    }

    $sponsor->logo = $this->updateFile($data['logo'] ??null,$sponsor->logo,'sponsors',$this->imageConverterService);
    


    $sponsor->save();

    return $sponsor;
}




   

public function getAllSponsors(array $data){

 $size = $data['size'] ?? 10;
 $page = $data['page'] ?? 1;


return $this->sponsorRepository->getAll($page,$size) ;


}
    




public function deleteSponsor(string $id)
{
    $sponsor = $this->sponsorRepository->find($id);
    
    if (!$sponsor) {
        return false;
    }
    
    $this->deleteFile($sponsor->logo);
    
    return $this->sponsorRepository->delete($id);
}








    
}
