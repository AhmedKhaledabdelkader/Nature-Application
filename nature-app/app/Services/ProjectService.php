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
     
    $this->localizeFields($data, ['name','overview','brief','result','project_reflected','start_date','end_date'], $locale);
       
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

    // Get a single project
    public function getProjectById(string $id)
    {
        return $this->projectRepository->find($id);
    }

    // Update project
    public function updateProject(string $id, array $data)
    {

        $locale = app()->getLocale();


        $project = $this->projectRepository->find($id);
        if (!$project) {
            return null;
        }

     

      $this->setLocalizedFields($project, $data, ['name','overview','brief','result','project_reflected','start_date','end_date'], $locale);

        $project->image_before = $this->updateFile($data['image_before'] ??null,
        $project->image_before,'projects',$this->imageConverterService);

      
         $project->image_after = $this->updateFile($data['image_after'] ??null,
        $project->image_after,'projects',$this->imageConverterService);


        $project->gallery = $this->updateMultipleFiles(
            $data['gallery'] ?? null,
            $project->gallery,
            'projects',
            $this->imageConverterService
        );


        $this->syncRelation($project, 'services', $data['service_ids'] ?? []);
    
        $project->save();

        return $project;
    }

    // Delete project
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
}

