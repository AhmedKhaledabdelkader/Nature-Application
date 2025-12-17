<?php

namespace App\Services;

use App\Repositories\Eloquents\AwardRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class AwardService
{

    public $awardRepository;
    
    public function __construct(AwardRepository $awardRepository,protected ImageConverterService $imageConverterService)
    {
        $this->awardRepository = $awardRepository;
        
    }


    public function createAward(array $data) 
    {
         $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        $data['title'] = [
           $locale => $data['title'] ?? null,
        ];

        $data['description'] = [
           $locale => $data['description'] ?? null,
        ];

        $data['url'] = [
           $locale => $data['url'] ?? null,
        ];

        $data['organization_name'] = [
           $locale => $data['organization_name'] ?? null,
        ];

        if (!empty($data['image'])) {

            $data['image'] = $this->imageConverterService->convertAndStore($data['image'], 'awards/images');
        }

        if (!empty($data['organization_logo'])) {
            

            $data['organization_logo'] = $this->imageConverterService->convertAndStore($data['organization_logo'], 'awards/organizations/logos');
        
        }


         if (!empty($data['content_file'])) {

        $imagePath=$data["content_file"]->store("awards/contents","private");
        $data['content_file']=$imagePath;

        }

        return $this->awardRepository->create($data);

        
    }



     public function updateAward(string $id, array $data)
    {
        $award = $this->awardRepository->find($id);

        if (!$award) {
            return null;
        }

        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        // Update localized fields
        if (isset($data['title'])) {
          

               $award->setLocalizedValue('title', $locale, $data['title']);
        }

        if (isset($data['description'])) {
         
            $award->setLocalizedValue('description', $locale, $data['description']);
        }

        if (isset($data['url'])) {
          
            $award->setLocalizedValue('url', $locale, $data['url']);
        }

        if (isset($data['organization_name'])) {
            
            $award->setLocalizedValue('organization_name', $locale, $data['organization_name']);
        }

        // Update image
        if (!empty($data['image'])) {
            if ($award->image && Storage::disk('private')->exists($award->image)) {
                Storage::disk('private')->delete($award->image);
            }
            $award->image = $this->imageConverterService->convertAndStore($data['image'], 'awards/images');
        }

        // Update organization logo
        if (!empty($data['organization_logo'])) {
            if ($award->organization_logo && Storage::disk('private')->exists($award->organization_logo)) {
                Storage::disk('private')->delete($award->organization_logo);
            }
            $award->organization_logo = $this->imageConverterService->convertAndStore($data['organization_logo'], 'awards/organizations/logos');
        }

        // Update content file
        if (!empty($data['content_file'])) {
            if ($award->content_file && Storage::disk('private')->exists($award->content_file)) {
                Storage::disk('private')->delete($award->content_file);
            }
            $award->content_file = $data['content_file']->store('awards/contents', 'private');
        }

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
        
        // Delete image if exists
        if ($award->image && Storage::disk('private')->exists($award->image)) {
            Storage::disk('private')->delete($award->image);
        }

        // Delete organization logo if exists
        if ($award->organization_logo && Storage::disk('private')->exists($award->organization_logo)) {
            Storage::disk('private')->delete($award->organization_logo);
        }

        // Delete content file if exists
        if ($award->content_file && Storage::disk('private')->exists($award->content_file)) {
            Storage::disk('private')->delete($award->content_file);
        }
        
        return $this->awardRepository->delete($id);
    }














}
