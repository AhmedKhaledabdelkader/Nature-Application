<?php

namespace App\Services;

use App\Repositories\Contracts\ProjectRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public $projectRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        protected ImageConverterService $imageConverterService
    ) {
        $this->projectRepository = $projectRepository;
    }

    // Create (already done)
    public function createProject(array $data)
    {
        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        // Localized fields
        $data['name'] = [$locale => $data['name'] ?? null];
        $data['overview'] = [$locale => $data['overview'] ?? null];
        $data['brief'] = [$locale => $data['brief'] ?? null];
        $data['result'] = [$locale => $data['result'] ?? null];
        $data['project_reflected'] = [$locale => $data['project_reflected'] ?? null];
        $data['start_date'] = [$locale => $data['start_date'] ?? null];
        $data['end_date'] = [$locale => $data['end_date'] ?? null];

        // Images
        if (!empty($data['image_before'])) {
            $data['image_before'] = $this->imageConverterService->convertAndStore($data['image_before'], 'projects');
        }

        if (!empty($data['image_after'])) {
            $data['image_after'] = $this->imageConverterService->convertAndStore($data['image_after'], 'projects');
        }

        if (!empty($data['gallery']) && is_array($data['gallery'])) {
            $galleryPaths = [];
            foreach ($data['gallery'] as $image) {
                $galleryPaths[] = $this->imageConverterService->convertAndStore($image, 'projects');
            }
            $data['gallery'] = $galleryPaths;
        } else {
            $data['gallery'] = [];
        }

        return $this->projectRepository->create($data);
    }

    // Get all projects with pagination
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
        $project = $this->projectRepository->find($id);
        if (!$project) {
            return null;
        }

        $locale = $data['locale'] ?? 'en';
        App::setLocale($locale);

        // Localized fields
        $localizedFields = ['name','overview','brief','result','project_reflected','start_date','end_date'];
        foreach ($localizedFields as $field) {
            if (isset($data[$field])) {
                $project->setLocalizedValue($field, $locale, $data[$field]);
            }
        }

        // Images
        if (!empty($data['image_before'])) {
            if ($project->image_before && Storage::disk('private')->exists($project->image_before)) {
                Storage::disk('private')->delete($project->image_before);
            }
            $project->image_before = $this->imageConverterService->convertAndStore($data['image_before'], 'projects');
        }

        if (!empty($data['image_after'])) {
            if ($project->image_after && Storage::disk('private')->exists($project->image_after)) {
                Storage::disk('private')->delete($project->image_after);
            }
            $project->image_after = $this->imageConverterService->convertAndStore($data['image_after'], 'projects');
        }

        if (!empty($data['gallery']) && is_array($data['gallery'])) {
            // Delete old gallery
            if ($project->gallery && is_array($project->gallery)) {
                foreach ($project->gallery as $oldImage) {
                    if (Storage::disk('private')->exists($oldImage)) {
                        Storage::disk('private')->delete($oldImage);
                    }
                }
            }
            $galleryPaths = [];
            foreach ($data['gallery'] as $image) {
                $galleryPaths[] = $this->imageConverterService->convertAndStore($image, 'projects');
            }
            $project->gallery = $galleryPaths;
        }

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

        // Delete images
        if ($project->image_before && Storage::disk('private')->exists($project->image_before)) {
            Storage::disk('private')->delete($project->image_before);
        }

        if ($project->image_after && Storage::disk('private')->exists($project->image_after)) {
            Storage::disk('private')->delete($project->image_after);
        }

        if ($project->gallery && is_array($project->gallery)) {
            foreach ($project->gallery as $img) {
                if (Storage::disk('private')->exists($img)) {
                    Storage::disk('private')->delete($img);
                }
            }
        }

        return $this->projectRepository->delete($id);
    }
}

