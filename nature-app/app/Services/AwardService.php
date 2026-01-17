<?php

namespace App\Services;

use App\Repositories\Contracts\AwardRepositoryInterface;
use App\Repositories\Eloquents\AwardRepository;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesMultipleFileUpload;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use App\Traits\SyncRelations;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class AwardService
{


    use HandlesFileUpload,HandlesLocalization,HandlesMultipleFileUpload,LocalizesData,HandlesUnlocalized,SyncRelations ;

    public $awardRepository;
    
    public function __construct(AwardRepositoryInterface $awardRepository,protected ImageConverterService $imageConverterService)
    {
        $this->awardRepository = $awardRepository;
        
    }


    public function createAward(array $data) 
    {
        
   $locale = app()->getLocale();

   $this->localizeFields($data,['name','description'],$locale);

   $data["image"]=$this->uploadFile($data['image'] ?? null, 'awards/images', $this->imageConverterService);


    $data['organizations_logos'] = $this->uploadMultipleFiles($data['organizations_logos'] ?? null
    ,'awards/organizations/logos',$this->imageConverterService);

   $award= $this->awardRepository->create($data);


   return $award ;

}

        
    



     public function updateAward(string $id, array $data)
    {

    $locale = app()->getLocale();


    $award = $this->awardRepository->find($id);

    if (!$award) {
            return null;
        }

    
    $this->setLocalizedFields($award, $data, ['name','description'],$locale);  

    $this->setUnlocalizedFields($award, $data, ['year','status']);

    $award->image = $this->updateFile($data['image'] ??null,$award->image,'awards/images',$this->imageConverterService);

    $award->organizations_logos = $this->updateMultipleFiles($data['organizations_logos'] ??null,
     $award->organizations_logos,'awards/organizations/logos',$this->imageConverterService);

    $award->save();

    return $award;

    }


    public function getAllAwards()
    {

    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;


    return $this->awardRepository->all($page, $size);

    }
    

    public function getAwardById(string $id)
    {

        return $this->awardRepository->find($id);

    }






    public function deleteAward(string $id)
    {
        $award = $this->awardRepository->find($id);
        
        if (!$award) {
            return false;
        }

        $this->deleteFile($award->image);

        $this->deleteMultipleFiles($award->organizations_logos);

        return $this->awardRepository->delete($id);


    }





}
