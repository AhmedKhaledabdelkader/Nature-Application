<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectMetricResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,   
            'metricName' => $this->metric_name,
            'metricValue' => $this->metric_value,
            'projectId' => $this->project_id,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
        
    }
}
