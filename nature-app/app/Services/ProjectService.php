<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use App\Traits\HandlesFileUpload;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesMultipleFileUpload;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use App\Traits\SyncRelations;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProjectService
{


    use HandlesFileUpload,HandlesMultipleFileUpload,HandlesLocalization,
    HandlesUnlocalized,LocalizesData,SyncRelations;

   



    public $projectRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        protected ImageConverterService $imageConverterService
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function createProject(array $data)
    {
       
    $locale = app()->getLocale();
     
    $this->localizeFields($data, ['name','overview','brief'], $locale);


      if (!empty($data['results']) && is_array($data['results'])) {

        foreach ($data['results'] as $i => &$result) {


            if (!isset($result['id'])) {
            $result['id'] = Str::uuid()->toString();
        }

            $this->localizeFields($result, ['section_title', 'section_body'], $locale);
        }
        unset($result); 
    }



      if (!empty($data['metrics']) && is_array($data['metrics'])) {

        foreach ($data['metrics'] as $i => &$metric) {

             if (!isset($metric['id'])) {
            $metric['id'] = Str::uuid()->toString();
        }

            $this->localizeFields($metric, ['metric_title'], $locale);

                    
        $metric['metric_number'] = $metric['metric_number'] ?? null;
        $metric['metric_case']   = $metric['metric_case'] ?? null;


            
        }
        unset($metric); 
    }

       
    $data["image_before"] = $this->uploadFile($data['image_before'] ?? null, 'projects', $this->imageConverterService);

    $data["image_after"] = $this->uploadFile($data['image_after'] ?? null, 'projects', $this->imageConverterService);

    $data['gallery'] = $this->uploadMultipleFiles(   $data['gallery'] ?? null,  'projects',$this->imageConverterService);
     
    $project= $this->projectRepository->create($data);
     
    $this->syncRelation($project, 'services', $data['service_ids'] ?? []);

    return $project ;

    }


 
    public function getAllProjects(array $data)
    {
        $size = $data['size'] ?? 10;
        $page = $data['page'] ?? 1;

        return $this->projectRepository->all($page, $size);
    }

   
    public function getProjectById(string $id)
    {
        return $this->projectRepository->find($id);
    }


  

    public function updateProject(string $id, array $data)
{
    $locale = app()->getLocale();

    $project = $this->projectRepository->find($id);
    if (!$project) {
        return null;
    }

    // =========================
    // TOP LEVEL
    // =========================
    $this->setLocalizedFields($project, $data, ['name', 'overview', 'brief'], $locale);
    $this->setUnlocalizedFields($project, $data, ['start_date', 'end_date', 'status']);

    // =========================
    // RESULTS
    // =========================
    if (!empty($data['results']) && is_array($data['results'])) {

        $existingResults = $project->results ?? [];

        foreach ($data['results'] as $incoming) {

            // ================= UPDATE EXISTING RESULT =================
            if (!empty($incoming['id'])) {

                foreach ($existingResults as $key => &$stored) {

                    if ($stored['id'] === $incoming['id']) {

                        // Check if only ID is sent (delete entire locale)
                        $onlyIdSent = (count($incoming) === 1);

                        if ($onlyIdSent) {
                            // DELETE all fields for this locale
                            foreach (['section_title', 'section_body'] as $field) {
                                if (isset($stored[$field][$locale])) {
                                    unset($stored[$field][$locale]);
                                }
                            }
                        } else {
                            // UPDATE ONLY PROVIDED FIELDS, KEEP OTHERS UNCHANGED

                            // ---------- SECTION_TITLE ----------
                            if (array_key_exists('section_title', $incoming)) {
                                $this->mergeLocalizedFields($incoming, ['section_title'], $locale, $stored);
                                $stored['section_title'] = $incoming['section_title'];
                            }

                            // ---------- SECTION_BODY ----------
                            if (array_key_exists('section_body', $incoming)) {
                                $this->mergeLocalizedFields($incoming, ['section_body'], $locale, $stored);
                                $stored['section_body'] = $incoming['section_body'];
                            }
                        }

                        // ---------- CHECK EMPTY RESULT ----------
                        $allEmpty = true;

                        foreach (['section_title', 'section_body'] as $field) {
                            if (!empty($stored[$field]) && count($stored[$field]) > 0) {
                                $allEmpty = false;
                                break;
                            }
                        }

                        if ($allEmpty) {
                            // Delete result completely
                            unset($existingResults[$key]);
                        }

                        break;
                    }
                }

                unset($stored);
            }
            // ================= CREATE NEW RESULT =================
            else {

                $incoming['id'] = Str::uuid()->toString();

                // Localize fields
                $this->mergeLocalizedFields($incoming, ['section_title', 'section_body'], $locale, null);

                $existingResults[] = $incoming;
            }
        }

        // Save back
        $project->results = array_values($existingResults);
    }

    // =========================
    // METRICS
    // =========================
    if (!empty($data['metrics']) && is_array($data['metrics'])) {

        $existingMetrics = $project->metrics ?? [];

        foreach ($data['metrics'] as $incoming) {

            // ================= UPDATE EXISTING METRIC =================
            if (!empty($incoming['id'])) {

                foreach ($existingMetrics as $key => &$stored) {

                    if ($stored['id'] === $incoming['id']) {

                        // Check if only ID is sent (delete entire locale)
                        $onlyIdSent = (count($incoming) === 1);

                        if ($onlyIdSent) {
                            // DELETE metric_title for this locale
                            if (isset($stored['metric_title'][$locale])) {
                                unset($stored['metric_title'][$locale]);
                            }
                        } else {
                            // UPDATE ONLY PROVIDED FIELDS, KEEP OTHERS UNCHANGED

                            // ---------- METRIC_TITLE ----------
                            if (array_key_exists('metric_title', $incoming)) {
                                $this->mergeLocalizedFields($incoming, ['metric_title'], $locale, $stored);
                                $stored['metric_title'] = $incoming['metric_title'];
                            }

                            // ---------- METRIC_NUMBER ----------
                            if (array_key_exists('metric_number', $incoming)) {
                                $stored['metric_number'] = $incoming['metric_number'];
                            }

                            // ---------- METRIC_CASE ----------
                            if (array_key_exists('metric_case', $incoming)) {
                                $stored['metric_case'] = $incoming['metric_case'];
                            }
                        }

                        // ---------- CHECK EMPTY METRIC ----------
                        if (empty($stored['metric_title'])) {
                            // Delete metric completely
                            unset($existingMetrics[$key]);
                        }

                        break;
                    }
                }

                unset($stored);
            }
            // ================= CREATE NEW METRIC =================
            else {

                $incoming['id'] = Str::uuid()->toString();

                // Localize title
                $this->mergeLocalizedFields($incoming, ['metric_title'], $locale, null);

                // Non-localized fields
                $incoming['metric_number'] = $incoming['metric_number'] ?? null;
                $incoming['metric_case'] = $incoming['metric_case'] ?? null;

                $existingMetrics[] = $incoming;
            }
        }

        // Save back
        $project->metrics = array_values($existingMetrics);
    }

    // =========================
    // IMAGES
    // =========================
    $project->image_before = $this->updateFile(
        $data['image_before'] ?? null,
        $project->image_before,
        'projects',
        $this->imageConverterService
    );

    $project->image_after = $this->updateFile(
        $data['image_after'] ?? null,
        $project->image_after,
        'projects',
        $this->imageConverterService
    );

    // =========================
    // GALLERY
    // =========================
    $project->gallery = $this->updateMultipleFiles(
        $data['gallery'] ?? null,
        $project->gallery,
        'projects',
        $this->imageConverterService
    );

    // =========================
    // SYNC SERVICES
    // =========================
    $this->syncRelation($project, 'services', $data['service_ids'] ?? []);

    // =========================
    // SAVE
    // =========================
    $project->save();

    return $project;
}


    

  
    public function deleteProject(string $id)
    {
        $project = $this->projectRepository->find($id);
        
        if (!$project) {
            return false;
        }

        $this->deleteFile($project->image_before);
        $this->deleteFile($project->image_after);
        $this->deleteMultipleFiles($project->gallery);

        $project->services()->detach();

        return $this->projectRepository->delete($id);
    }



public function searchProject(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;
    $key= $data['key'] ?? 'name';
    $value= $data['value'] ?? '';


    return $this->projectRepository->search($key,$value, $page, $size);


}



}

