<?php

namespace App\Repositories\Eloquents;

use App\Models\Project;
use App\Repositories\Contracts\ProjectRepositoryInterface;

class ProjectRepository implements ProjectRepositoryInterface
{


    public function create(array $data)
     {

        return Project::create($data) ;

}



 public function find(string $id)
    {
        return Project::find($id);
    }

    public function all($page, $size)
    {
        return Project::query()->paginate($size, ['*'], 'page', $page);
    }


    public function delete(string $id): bool
    {
        $project = Project::find($id);
        if ($project) {
            return $project->delete();
        }
        return false;
    }

    
}
