<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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

            // Translatable fields (already resolved by middleware / model)
            'name' => $this->name,
            'overview' => $this->overview,
            'brief' => $this->brief,
            'result' => $this->result,
            'project_reflected' => $this->project_reflected,

            // Dates
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,

            // Images
            'image_before' => $this->image_before,
            'image_after' => $this->image_after,
            'gallery' => $this->gallery ?? [],

            // Relations
            'city' => $this->whenLoaded('city', function () {
                return [
                    'id' => $this->city->id,
                    'name' => $this->city->name,
                ];
            }),

            'country' => $this->whenLoaded('country', function () {
                return [
                    'id' => $this->country->id,
                    'name' => $this->country->name,
                ];
            }),

    'services' => $this->whenLoaded('services', function () {

    return $this->services->map(function ($service) {
        return [
            'id' => $service->id,
            'title' => $service->title,
        ];
    });
}),



            // Meta
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];







        
    }
}
