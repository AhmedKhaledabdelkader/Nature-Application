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

   
}
