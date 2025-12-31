<?php

namespace App\Repositories\Eloquents;

use App\Models\Project_Metrics;
use App\Repositories\Contracts\ProjectMetricRepositoryInterface;

class ProjectMetricRepository implements ProjectMetricRepositoryInterface
{

    public function create(array $data)
    {
        return Project_Metrics::create($data);
    }

    public function find(string $id)
    {
        return Project_Metrics::find($id);
    }


    
    public function delete(string $id): bool
{
    $project_metric = Project_Metrics::find($id);
    
    if ($project_metric) {
        return $project_metric->delete();
    }
    
    return false;
}


    public function getAll()
    {
        return Project_Metrics::all();
    }



   
}
