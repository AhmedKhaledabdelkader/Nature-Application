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

        $locale = app()->getLocale();


        return [
            'id' => $this->id,

            // Translatable fields (already resolved by middleware / model)
            'name' => $this->name,
            'overview' => $this->overview,
            'brief' => $this->brief,
            'results'=>$this->formatResults($locale),
            'metrics'=>$this->formatMetrics($locale),

            // Dates
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,

            // Images
            'imageBefore' => $this->image_before,
            'imageAfter' => $this->image_after,
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

            'status'=>$this->status,

    'services' => $this->whenLoaded('services', function () {

    return $this->services->map(function ($service) {
        return [
            'id' => $service->id,
            'name' => $service->name,
        ];
    });
}),

 

 'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,
            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,

          



        ];


 
    }



 private function formatResults(string $locale): array
    {
        if (!$this->results) return [];

        return collect($this->results)
            ->map(fn($result) => [
               
                'id'=>$result['id'],
                'sectionTitle' => is_array($result['section_title']) ? ($result['section_title'][$locale] ?? null) : $result['section_title'],
                'sectionBody' => is_array($result['section_body']) ? ($result['section_body'][$locale] ?? null) : $result['section_body'],
           
            ])
            ->toArray();
    }


    private function formatMetrics(string $locale): array
    {
        if (!$this->metrics) return [];

        return collect($this->metrics)
            ->map(fn($metric) => [
               
                 'id'=>$metric['id'],
                'metricTitle' => is_array($metric['metric_title']) ? ($metric['metric_title'][$locale] ?? null) : $metric['metric_title'],
                'metricNumber' => $metric['metric_number'],
                'metricCase' => $metric['metric_case'],
           
            ])
            ->toArray();
    }



}
