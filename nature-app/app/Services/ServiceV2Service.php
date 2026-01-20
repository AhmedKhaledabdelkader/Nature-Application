<?php

namespace App\Services;

use App\Models\ServiceV2;
use App\Repositories\Contracts\ServiceV2RepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;

class ServiceV2Service
{


    use HandlesFileUpload,LocalizesData,HandlesLocalization,HandlesUnlocalized ;

    public $serviceV2Repository ;

    public function __construct(ServiceV2RepositoryInterface $serviceV2Repository,protected ImageConverterService $imageConverterService)
    {
        $this->serviceV2Repository=$serviceV2Repository ;
        
    }



public function addService(array $data)
{
    $locale = app()->getLocale();

    // Localize top-level fields
    $this->localizeFields($data, ['name', 'tagline'], $locale);

    // =========================
    // STEPS
    // =========================
    if (!empty($data['steps']) && is_array($data['steps'])) {
        foreach ($data['steps'] as $i => &$step) {
            // Localize title & description
            $this->localizeFields($step, ['title', 'description'], $locale);

            // Upload image if exists
            if (!empty($step['image'])) {
                $step['image'] = $this->uploadFile(
                    $step['image'],
                    'services/steps',
                    $this->imageConverterService
                );
            }

           
            $step['order'] = $i + 1; 
        }
        unset($step); 
    }

    // =========================
    // BENEFITS
    // =========================
    if (!empty($data['benefits']) && is_array($data['benefits'])) {
        foreach ($data['benefits'] as $i => &$benefit) {
            $this->localizeFields($benefit, ['title', 'tagline', 'body'], $locale);

            // Localize insights
            if (!empty($benefit['insights']) && is_array($benefit['insights'])) {
                foreach ($benefit['insights'] as &$insight) {
                    // Only localize string fields
                    $this->localizeFields($insight, ['metric_title'], $locale);
                    // Do NOT localize metric_number (numeric)
                }
                unset($insight);
            }
        }
        unset($benefit);
    }

    // =========================
    // VALUES
    // =========================
    if (!empty($data['values']) && is_array($data['values'])) {
        foreach ($data['values'] as $i => &$value) {
            $this->localizeFields($value, ['title', 'description'], $locale);

            // Localize tools
            if (!empty($value['tools']) && is_array($value['tools'])) {
           foreach ($value['tools'] as $j => $tool) {
       ;

       
        $value['tools'][$j] = $tool;
    }
}
        }
        unset($value);
    }

    // =========================
    // IMPACTS
    // =========================
    if (!empty($data['impacts']) && is_array($data['impacts'])) {
        foreach ($data['impacts'] as $i => &$impact) {
            $this->localizeFields($impact, ['title', 'description'], $locale);

            if (!empty($impact['image'])) {
                $impact['image'] = $this->uploadFile(
                    $impact['image'],
                    'services/impacts',
                    $this->imageConverterService
                );
            }
        }
        unset($impact);
    }

    
    $data['steps'] = $data['steps'] ?? [];
    $data['benefits'] = $data['benefits'] ?? [];
    $data['values'] = $data['values'] ?? [];
    $data['impacts'] = $data['impacts'] ?? [];

    
    $service = ServiceV2::create($data);

    return $service;
}



// Get by ID
    public function getServiceById(string $id)
    {
        return $this->serviceV2Repository->find($id);
    }


public function updateService(array $data, string $id)
{
    $locale = app()->getLocale();

    $service = $this->serviceV2Repository->find($id);

    if (!$service) {
        return null;
    }

    // =========================
    // TOP LEVEL (MODEL FIELDS)
    // =========================

    $this->setLocalizedFields($service, $data, ['name', 'tagline'], $locale);

    $this->setUnlocalizedFields($service,$data,['status']) ;

    // =========================
    // STEPS
    // =========================

    if (!empty($data['steps']) && is_array($data['steps'])) {

        foreach ($data['steps'] as $i => &$step) {

            // Localize array values (NOT model)
            $this->localizeFields($step, ['title', 'description'], $locale);

            // Image update
            $step['image'] = $this->updateFile(
                $step['image'] ?? null,
                $service->steps[$i]['image'] ?? null,
                'services/steps',
                $this->imageConverterService
            );

            // Order
            $step['order'] = $i + 1;
        }

        unset($step);

        // Assign back
        $service->steps = $data['steps'];
    }

    // =========================
    // BENEFITS
    // =========================

    if (!empty($data['benefits']) && is_array($data['benefits'])) {

        foreach ($data['benefits'] as &$benefit) {

            $this->localizeFields($benefit, ['title', 'tagline', 'body'], $locale);

            if (!empty($benefit['insights'])) {

                foreach ($benefit['insights'] as &$insight) {

                    $this->localizeFields($insight, ['metric_title'], $locale);
                }

                unset($insight);
            }
        }

        unset($benefit);

        $service->benefits = $data['benefits'];
    }

    // =========================
    // VALUES
    // =========================

    if (!empty($data['values']) && is_array($data['values'])) {

        foreach ($data['values'] as &$value) {

            $this->localizeFields($value, ['title', 'description'], $locale);

            // Tools are plain array — no localization
            $value['tools'] = $value['tools'] ?? [];
        }

        unset($value);

        $service->values = $data['values'];
    }

    // =========================
    // IMPACTS
    // =========================

    if (!empty($data['impacts']) && is_array($data['impacts'])) {

        foreach ($data['impacts'] as $i => &$impact) {

            $this->localizeFields($impact, ['title', 'description'], $locale);

            $impact['image'] = $this->updateFile(
                $impact['image'] ?? null,
                $service->impacts[$i]['image'] ?? null,
                'services/impacts',
                $this->imageConverterService
            );
        }

        unset($impact);

        $service->impacts = $data['impacts'];
    }

   

    $service->save();

    return $service;
}







public function deleteService(string $id)
{
    $service = $this->serviceV2Repository->find($id);

    if (!$service) {
        return false;
    }




    // =========================
    // STEPS IMAGES
    // =========================

    if (!empty($service->steps) && is_array($service->steps)) {

        foreach ($service->steps as $step) {

            if (!empty($step['image'])) {
                $this->deleteFile($step['image']);
            }
        }
    }

    // =========================
    // IMPACTS IMAGES
    // =========================

    if (!empty($service->impacts) && is_array($service->impacts)) {

        foreach ($service->impacts as $impact) {

            if (!empty($impact['image'])) {
                $this->deleteFile($impact['image']);
            }
        }
    }

    // =========================
    // DELETE RECORD
    // =========================

    return $this->serviceV2Repository->delete($id);
}



public function getAllServices(array $data){

 $size = $data['size'] ?? 10;
 $page = $data['page'] ?? 1;

 return $this->serviceV2Repository->getAll($page,$size) ;


}

public function getAllPublishedServices(array $data){

 $size = $data['size'] ?? 10;
 $page = $data['page'] ?? 1;

 return $this->serviceV2Repository->getAllPublishedServices($page,$size) ;


}






public function getAllServicesNames()
{

    return $this->serviceV2Repository->getAllServicesNames() ;


}










}
