<?php

namespace App\Services;

use App\Repositories\Contracts\AwardRepositoryInterface;
use App\Repositories\Eloquents\AwardRepository;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class AwardService
{


    use HandlesFileUpload,HandlesLocalization,LocalizesData,HandlesUnlocalized ;

    public $awardRepository;
    
    public function __construct(AwardRepositoryInterface $awardRepository,protected ImageConverterService $imageConverterService)
    {
        $this->awardRepository = $awardRepository;
        
    }


    public function createAward(array $data) 
    {
        
        $locale = app()->getLocale();

        $this->localizeFields($data,['title','description','url','organization_name'],$locale);

    $data["image"]=$this->uploadFile($data['image'] ?? null, 'awards/images', $this->imageConverterService);
    $data["organization_logo"]=$this->uploadFile($data['organization_logo'] ?? null, 'awards/organizations/logos', $this->imageConverterService);
    $data["content_file"]=$this->uploadContentFile($data["content_file"]??null,"awards/contents");

        return $this->awardRepository->create($data);

        
    }



     public function updateAward(string $id, array $data)
    {
        $locale = app()->getLocale();


        $award = $this->awardRepository->find($id);

        if (!$award) {
            return null;
        }

    
        $this->setLocalizedFields($award, $data, ['title','description','url','organization_name'],$locale);  

        $award->image = $this->updateFile($data['image'] ??null,$award->image,'awards/images',$this->imageConverterService);

        $award->organization_logo = $this->updateFile($data['organization_logo'] ??null,
        $award->organization_logo,'awards/organizations/logos',$this->imageConverterService);

       $award->content_file=$this->updateContentFile($data["content_file"]??null,$award->content_file,"awards/contents");
 
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
        return $this->awardRepository->findWithSponsors($id);
    }






    public function deleteAward(string $id)
    {
        $award = $this->awardRepository->find($id);
        
        if (!$award) {
            return false;
        }

        $this->deleteFile($award->image);
        $this->deleteFile($award->organization_logo);
        $this->deleteContentFile($award->content_file) ;
        
        return $this->awardRepository->delete($id);
    }














}
