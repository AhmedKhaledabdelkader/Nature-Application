<?php

namespace App\Services;

use App\Models\Provided_Service;
use App\Repositories\Contracts\ProvidedServiceRepositoryInterface;
use App\Repositories\Contracts\StepRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Request;

class StepService
{
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
        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

 $data['title'] = [$locale => $data['title'] ?? null,];
 $data['description'] = [$locale => $data['description'] ?? null,];

if (!empty($data['image'])) {

    $data['image'] = $this->imageConverterService->convertAndStore($data['image'], 'steps');

    }


        // Determine order
        $order = $data['order_index']
            ?? $service->steps()->count() + 1;


            $step=$this->stepRepository->create($data);

        // Attach step with order
        $service->steps()->attach($step->id, [
            'order_index' => $order
        ]);

        return $service;
    }


    public function updateStep(array $data) {


        $step = $this->stepRepository->find($data["stepId"]);
         $service = $this->serviceRepository->find($data["serviceId"]);

        if (!$step || !$service) {
            return null;
        }

        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        // Update localized title
        if (isset($data['title'])) {
            $step->setLocalizedValue('title', $locale, $data['title']);
        }

        // Update localized description
        if (isset($data['description'])) {
            $step->setLocalizedValue('description', $locale, $data['description']);
        }

        // Update image (delete old → store new)
        if (!empty($data['image'])) {

            if ($step->image && Storage::disk('private')->exists($step->image)) {
                Storage::disk('private')->delete($step->image);
            }

            $step->image = $this->imageConverterService
                ->convertAndStore($data['image'], 'steps');
        }

        $step->save();

        // Update order_index if provided
        if (isset($data['order_index'])) {
            $service->steps()->updateExistingPivot($data["stepId"], [
                'order_index' => $data['order_index'],
            ]);
        }

        return $step;
    }

    /**
     * DELETE STEP
     */

    
    public function deleteStep(array $data)
    {
      
        $step = $this->stepRepository->find($data["stepId"]);
        $service = $this->serviceRepository->find($data["serviceId"]);

        if (!$step || !$service) {
            return null;
        }


        // delete image
        if ($step->image && Storage::disk('private')->exists($step->image)) {
            Storage::disk('private')->delete($step->image);
        }

        // detach from service
        $service->steps()->detach($data["stepId"]);

        // delete step
        $this->stepRepository->delete($data["stepId"]);

        return true;
    }













}
