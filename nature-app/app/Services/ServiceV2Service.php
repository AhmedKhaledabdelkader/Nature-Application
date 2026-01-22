<?php

namespace App\Services;

use App\Models\ServiceV2;
use App\Repositories\Contracts\ServiceV2RepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Illuminate\Support\Str;

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


    $this->localizeFields($data, ['name', 'tagline'], $locale);

    // =========================
    // STEPS
    // =========================

    if (!empty($data['steps']) && is_array($data['steps'])) {

        foreach ($data['steps'] as $i => &$step) {

            $step['id'] = Str::uuid()->toString();

            // Localize
            $this->localizeFields($step, ['title', 'description'], $locale);

            // Image upload
            if (!empty($step['image'])) {

                $step['image'] = $this->uploadFile(
                    $step['image'],
                    'services/steps',
                    $this->imageConverterService
                );
            }

            // Order
            $step['order'] = $i + 1;
        }

        unset($step);
    }

    // =========================
    // BENEFITS
    // =========================

    if (!empty($data['benefits']) && is_array($data['benefits'])) {

        foreach ($data['benefits'] as &$benefit) {

            $benefit['id'] = Str::uuid()->toString();

            $this->localizeFields($benefit, ['title', 'tagline', 'body'], $locale);

            // Insights
            if (!empty($benefit['insights']) && is_array($benefit['insights'])) {

                foreach ($benefit['insights'] as &$insight) {

                    $insight['id'] = Str::uuid()->toString();

                    $this->localizeFields($insight, ['metric_title'], $locale);

                    // metric_number NOT localized
                    $insight['metric_number'] = $insight['metric_number'] ?? null;
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

        foreach ($data['values'] as &$value) {

            $value['id'] = Str::uuid()->toString();

            $this->localizeFields($value, ['title', 'description'], $locale);

            // Tools = plain array
            $value['tools'] = $value['tools'] ?? [];
        }

        unset($value);
    }

    // =========================
    // IMPACTS
    // =========================

    if (!empty($data['impacts']) && is_array($data['impacts'])) {

        foreach ($data['impacts'] as &$impact) {

            $impact['id'] = Str::uuid()->toString();

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

    // =========================
    // DEFAULT EMPTY ARRAYS
    // =========================

    $data['steps']    = $data['steps'] ?? [];
    $data['benefits'] = $data['benefits'] ?? [];
    $data['values']   = $data['values'] ?? [];
    $data['impacts']  = $data['impacts'] ?? [];

    // =========================
    // CREATE
    // =========================

    $service = ServiceV2::create($data);

    return $service;
}


// Get by ID
    public function getServiceById(string $id)
    {
        return $this->serviceV2Repository->find($id);
    }

/*
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
}*/



public function updateService(array $data, string $id)
{
    $locale = app()->getLocale();

    $service = $this->serviceV2Repository->find($id);

    if (!$service) {
        return null;
    }

    // =========================
    // TOP LEVEL
    // =========================
    $this->setLocalizedFields($service, $data, ['name', 'tagline'], $locale);
    $this->setUnlocalizedFields($service, $data, ['status']);

    // =========================
    // STEPS
    // =========================

    /*
    if (!empty($data['steps']) && is_array($data['steps'])) {

        $existingSteps = $service->steps ?? [];

        foreach ($data['steps'] as $incoming) {

            // UPDATE EXISTING STEP
            if (!empty($incoming['id'])) {
                foreach ($existingSteps as &$stored) {
                    if ($stored['id'] === $incoming['id']) {

                    

                    
                    

                        // Merge localized fields
                        $this->mergeLocalizedFields($incoming, ['title', 'description'], $locale, $stored);

                        // Handle image update
                        if (array_key_exists('image', $incoming)) {
                            $stored['image'] = $this->updateFile(
                                $incoming['image'],
                                $stored['image'] ?? null,
                                'services/steps',
                                $this->imageConverterService
                            );
                        }

                        // Merge back into stored record
                        $stored = array_merge($stored, $incoming);

                        break;
                    }
                }
                unset($stored);
            }
            // CREATE NEW STEP
            else {
                $incoming['id'] = Str::uuid()->toString();
                
                // Localize new step
                $this->mergeLocalizedFields($incoming, ['title', 'description'], $locale, null);

                // Handle image
                $incoming['image'] = $this->updateFile(
                    $incoming['image'] ?? null,
                    null,
                    'services/steps',
                    $this->imageConverterService
                );

                $existingSteps[] = $incoming;
            }
        }

        // Re-order all steps
        foreach ($existingSteps as $i => &$step) {
            $step['order'] = $i + 1;
        }
        unset($step);

        // Save back
        $service->steps = array_values($existingSteps);
    }
*/



if (!empty($data['steps']) && is_array($data['steps'])) {

    $existingSteps = $service->steps ?? [];

    foreach ($data['steps'] as $incoming) {

        // UPDATE EXISTING STEP
        if (!empty($incoming['id'])) {
            foreach ($existingSteps as $key => &$stored) {
                if ($stored['id'] === $incoming['id']) {

                    // Delete from specific locale if title/description is null
                    foreach (['title', 'description'] as $field) {
                
                        if (!array_key_exists($field, $incoming)) {

                           

                            if (isset($stored[$field][$locale])) {
                                unset($stored[$field][$locale]);
                             }
    } else {
        // Field exists → merge/update normally
        $this->mergeLocalizedFields($incoming, [$field], $locale, $stored);
    }
                    }

                    // If after deletion, both title & description have no locales left → delete step completely
                    $allEmpty = true;
                    foreach (['title', 'description'] as $field) {
                        if (!empty($stored[$field])) {

                            $allEmpty = false;
                            break;
                        }
                    }

                    if ($allEmpty) {

                       
                        // Delete step image using your trait
                        if (!empty($stored['image'])) {
                            
                            echo $stored["image"] ;
                            $this->deleteFile($stored['image']);
                           
                        }

                        // Remove step from existing steps
                        unset($existingSteps[$key]);
                    } else {
                        // Handle image update if step still exists
                        if (array_key_exists('image', $incoming)) {
                            $stored['image'] = $this->updateFile(
                                $incoming['image'],
                                $stored['image'] ?? null,
                                'services/steps',
                                $this->imageConverterService
                            );
                        }

                        // Merge back other fields
                        $stored = array_merge($stored, $incoming);
                    }

                    break;
                }
            }
            unset($stored);
        }
        // CREATE NEW STEP
        else {
            $incoming['id'] = Str::uuid()->toString();

            // Localize new step
            $this->mergeLocalizedFields($incoming, ['title', 'description'], $locale, null);

            // Handle image
            $incoming['image'] = $this->updateFile(
                $incoming['image'] ?? null,
                null,
                'services/steps',
                $this->imageConverterService
            );

            $existingSteps[] = $incoming;
        }
    }

    // Re-order all steps
    foreach ($existingSteps as $i => &$step) {
        $step['order'] = $i + 1;
    }
    unset($step);

    $service->steps = array_values($existingSteps);
}










    // =========================
    // BENEFITS
    // =========================
   if (!empty($data['benefits']) && is_array($data['benefits'])) {

        $existingBenefits = $service->benefits ?? [];

        foreach ($data['benefits'] as $incoming) {

            // UPDATE EXISTING BENEFIT
            if (!empty($incoming['id'])) {
                foreach ($existingBenefits as &$stored) {
                    if ($stored['id'] === $incoming['id']) {

                        // Merge localized fields
                        $this->mergeLocalizedFields($incoming, ['title', 'tagline', 'body'], $locale, $stored);

                        // Handle insights
                        if (!empty($incoming['insights']) && is_array($incoming['insights'])) {
                            $existingInsights = $stored['insights'] ?? [];

                            foreach ($incoming['insights'] as $incomingInsight) {

                                // UPDATE EXISTING INSIGHT
                                if (!empty($incomingInsight['id'])) {
                                    foreach ($existingInsights as &$storedInsight) {
                                        if ($storedInsight['id'] === $incomingInsight['id']) {

                                            // Merge metric_title
                                            $this->mergeLocalizedFields($incomingInsight, ['metric_title'], $locale, $storedInsight);

                                            // Keep non-localized fields
                                            $storedInsight['metric_number'] = $incomingInsight['metric_number'] ?? ($storedInsight['metric_number'] ?? null);

                                            // Merge back
                                            $storedInsight = array_merge($storedInsight, $incomingInsight);

                                            break;
                                        }
                                    }
                                    unset($storedInsight);
                                }
                                // CREATE NEW INSIGHT
                                else {
                                    $incomingInsight['id'] = Str::uuid()->toString();
                                    $this->mergeLocalizedFields($incomingInsight, ['metric_title'], $locale, null);
                                    $incomingInsight['metric_number'] = $incomingInsight['metric_number'] ?? null;
                                    $existingInsights[] = $incomingInsight;
                                }
                            }

                            $stored['insights'] = array_values($existingInsights);
                        }

                        // Merge back into stored record
                        $stored = array_merge($stored, $incoming);

                        break;
                    }
                }
                unset($stored);
            }
            // CREATE NEW BENEFIT
            else {
                $incoming['id'] = Str::uuid()->toString();
                
                // Localize benefit fields
                $this->mergeLocalizedFields($incoming, ['title', 'tagline', 'body'], $locale, null);

                // Handle insights
                if (!empty($incoming['insights']) && is_array($incoming['insights'])) {
                    foreach ($incoming['insights'] as &$insight) {
                        if (empty($insight['id'])) {
                            $insight['id'] = Str::uuid()->toString();
                        }
                        $this->mergeLocalizedFields($insight, ['metric_title'], $locale, null);
                        $insight['metric_number'] = $insight['metric_number'] ?? null;
                    }
                    unset($insight);
                } else {
                    $incoming['insights'] = [];
                }

                $existingBenefits[] = $incoming;
            }
        }

        // Save back
        $service->benefits = array_values($existingBenefits);
    }




    // =========================
    // VALUES
    // =========================
    if (!empty($data['values']) && is_array($data['values'])) {

        $existingValues = $service->values ?? [];

        foreach ($data['values'] as $incoming) {

            // UPDATE EXISTING VALUE
            if (!empty($incoming['id'])) {
                foreach ($existingValues as &$stored) {
                    if ($stored['id'] === $incoming['id']) {

                        // Merge localized fields
                        $this->mergeLocalizedFields($incoming, ['title', 'description'], $locale, $stored);

                        // Update tools (non-localized)
                        if (isset($incoming['tools'])) {
                            $stored['tools'] = $incoming['tools'];
                        }

                        // Merge back into stored record
                        $stored = array_merge($stored, $incoming);

                        break;
                    }
                }
                unset($stored);
            }
            // CREATE NEW VALUE
            else {
                $incoming['id'] = Str::uuid()->toString();
                
                // Localize value fields
                $this->mergeLocalizedFields($incoming, ['title', 'description'], $locale, null);

                // Set tools
                $incoming['tools'] = $incoming['tools'] ?? [];

                $existingValues[] = $incoming;
            }
        }

        // Save back
        $service->values = array_values($existingValues);
    }

    // =========================
    // IMPACTS
    // =========================
   if (!empty($data['impacts']) && is_array($data['impacts'])) {

    $existingImpacts = $service->impacts ?? [];

    foreach ($data['impacts'] as $incoming) {

        // ================= UPDATE EXISTING IMPACT =================
        if (!empty($incoming['id'])) {

            foreach ($existingImpacts as $key => &$stored) {

                if ($stored['id'] === $incoming['id']) {

                    /*
                    --------------------------------
                    Handle localized fields
                    --------------------------------
                    */

                    foreach (['title', 'description'] as $field) {

                        // Delete locale
                        if (!array_key_exists($field, $incoming)) {

                            if (isset($stored[$field][$locale])) {
                                unset($stored[$field][$locale]);
                            }

                        } else {

                            // Update locale
                            $this->mergeLocalizedFields(
                                $incoming,
                                [$field],
                                $locale,
                                $stored
                            );
                        }
                    }

                    /*
                    --------------------------------
                    Check if impact is empty
                    --------------------------------
                    */

                    $allEmpty = true;

                    foreach (['title', 'description'] as $field) {
                        if (!empty($stored[$field])) {
                            $allEmpty = false;
                            break;
                        }
                    }

                    /*
                    --------------------------------
                    Delete IMPACT completely
                    --------------------------------
                    */

                    if ($allEmpty) {

                        // Delete image from disk
                        if (!empty($stored['image'])) {
                            $this->deleteFile($stored['image']);
                        }

                        unset($existingImpacts[$key]);

                    } else {

                        /*
                        --------------------------------
                        Handle image update
                        --------------------------------
                        */

                        if (array_key_exists('image', $incoming)) {

                            $stored['image'] = $this->updateFile(
                                $incoming['image'],
                                $stored['image'] ?? null,
                                'services/impacts',
                                $this->imageConverterService
                            );
                        }

                        // Merge other fields
                        $stored = array_merge($stored, $incoming);
                    }

                    break;
                }
            }

            unset($stored);
        }

        // ================= CREATE NEW IMPACT =================
        else {

            $incoming['id'] = Str::uuid()->toString();

            // Localize fields
            $this->mergeLocalizedFields(
                $incoming,
                ['title', 'description'],
                $locale,
                null
            );

            // Upload image
            $incoming['image'] = $this->updateFile(
                $incoming['image'] ?? null,
                null,
                'services/impacts',
                $this->imageConverterService
            );

            $existingImpacts[] = $incoming;
        }
    }

    // Save back
    $service->impacts = array_values($existingImpacts);
}


    // =========================
    // SAVE
    // =========================
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
