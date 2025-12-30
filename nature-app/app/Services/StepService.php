<?php

namespace App\Services;

use App\Models\Provided_Service;
use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use App\Repositories\Contracts\StepRepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class StepService
{

    use HandlesFileUpload,HandlesLocalization,HandlesUnlocalized,LocalizesData ;
    public $stepRepository ;
    public $serviceRepository ;
    public function __construct(StepRepositoryInterface $stepRepository,ProvidedServiceRepositoryInterface $serviceRepository
    ,protected ImageConverterService $imageConverterService)
    {
        

        $this->stepRepository=$stepRepository ;

        $this->serviceRepository=$serviceRepository ;
    }


     public function addStepToService(Provided_Service $service, array $data)
    {

$locale = app()->getLocale();
        

$this->localizeFields($data, ['title','description'], $locale);

$data["image"]=$this->uploadFile($data['image'] ?? null, 'steps', $this->imageConverterService);

$order = $data['order_index']?? $service->steps()->count() + 1;

$step=$this->stepRepository->create($data);

        // Attach step with order
       $service->steps()->attach($step->id, [
            'order_index' => $order
        ]);

        return $service;
    }


    public function updateStep(array $data) {



        $locale = app()->getLocale();

        $step = $this->stepRepository->find($data["stepId"]);
        $service = $this->serviceRepository->find($data["serviceId"]);

        if (!$step || !$service) {
            return null;
        }

        $this->setLocalizedFields($step, $data, ['title','description'],$locale);

        $step->image = $this->updateFile($data['image'] ??null,$step->image,'steps',$this->imageConverterService);

        $step->save();

        if (isset($data['order_index'])) {
            $service->steps()->updateExistingPivot($data["stepId"], [
                'order_index' => $data['order_index'],
            ]);
        }

        return $step;
    }

  
    
    public function deleteStep(array $data)
    {
      
        $step = $this->stepRepository->find($data["stepId"]);
        $service = $this->serviceRepository->find($data["serviceId"]);

        if (!$step || !$service) {
            return null;
        }

        $this->deleteFile($step->image);

        $service->steps()->detach($data["stepId"]);

        $this->stepRepository->delete($data["stepId"]);

        return true;
    }













}
