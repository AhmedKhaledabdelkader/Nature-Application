<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectMetricRepositoryInterface;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;

class ProjectMetricService
{

    use LocalizesData, HandlesUnlocalized,HandlesLocalization ;


    public $projectMetricRepository;
    
    public function __construct(ProjectMetricRepositoryInterface $projectMetricRepository)
    {
        $this->projectMetricRepository = $projectMetricRepository;
    }



    public function createProjectMetric(array $data)
    {

         $locale = app()->getLocale();

        $this->localizeFields($data,['metric_name','metric_value'],$locale);

        return $this->projectMetricRepository->create($data);
    }


    public function updateProjectMetric(string $id, array $data)
    {
        $locale = app()->getLocale();


        
    $project_metric = $this->projectMetricRepository->find($id);

    if (!$project_metric) {
        return null;
    }

    $this->setLocalizedFields($project_metric, $data, ['metric_name', 'metric_value'], $locale);

    $this->setUnlocalizedFields($project_metric, $data, ['trend', 'project_id']);

    $project_metric->save();


    return $project_metric;


       
    }


    public function deleteProjectMetric(string $id)
    {
        $project_metric = $this->projectMetricRepository->find($id);

        if (!$project_metric) {
            return false;
        }

        return $this->projectMetricRepository->delete($id);
    }


    public function getAllProjectMetrics()
    {
        return $this->projectMetricRepository->getAll();
    }





   
}
