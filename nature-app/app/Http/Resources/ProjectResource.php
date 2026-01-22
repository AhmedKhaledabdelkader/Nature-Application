<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [

            'id' => $this->id,

            // Translated fields
            'name' => $this->translateField($this->name, $locale),
            'overview' => $this->translateField($this->overview, $locale),
            'brief' => $this->translateField($this->brief, $locale),


            // Arrays
            'results' => $this->formatResults($locale),
            'metrics' => $this->formatMetrics($locale),


            // Dates
            'startDate' => $this->start_date,
            'endDate' => $this->end_date,


            // Images
            'imageBefore' => $this->image_before,
            'imageAfter' => $this->image_after,
            'gallery' => $this->gallery ?? [],


            // Relations
            'city' => $this->whenLoaded('city', fn () => [
                'id' => $this->city->id,
                'name' => $this->city->name,
            ]),

            'country' => $this->whenLoaded('country', fn () => [
                'id' => $this->country->id,
                'name' => $this->country->name,
            ]),

            'services' => $this->whenLoaded('services', fn () =>
                $this->services->map(fn ($service) => [
                    'id' => $service->id,
                    'name' => $service->name,
                ])
            ),


            'status' => $this->status,


            // Dates formatted
            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,

            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
    }


    // ================= TRANSLATION HELPER =================

    private function translateField($field, string $locale)
{
    if (!$field) {
        return null;
    }

    if (is_array($field)) {
        $fallback = $locale === 'en' ? 'ar' : 'en';

        return $field[$locale] ?? $field[$fallback];
    }

    return $field;
}


    // ================= RESULTS =================

    private function formatResults(string $locale): array
    {
        if (empty($this->results)) return [];

        return collect($this->results)
            ->map(fn ($result) => [

                'id' => $result['id'] ?? null,

                'sectionTitle' => $this->translateField(
                    $result['section_title'] ?? null,
                    $locale
                ),

                'sectionBody' => $this->translateField(
                    $result['section_body'] ?? null,
                    $locale
                ),

            ])
            ->toArray();
    }


    // ================= METRICS =================

    private function formatMetrics(string $locale): array
    {
        if (empty($this->metrics)) return [];

        return collect($this->metrics)
            ->map(fn ($metric) => [

                'id' => $metric['id'] ?? null,

                'metricTitle' => $this->translateField(
                    $metric['metric_title'] ?? null,
                    $locale
                ),

                'metricNumber' => $metric['metric_number'] ?? null,

                'metricCase' => $metric['metric_case'] ?? null,

            ])
            ->toArray();
    }
}
