<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        // Build DTO for gallery
        $galleryDto = collect($this->gallery ?? [])
            ->values()
            ->map(function ($path, $index) {
                return [
                    'id'  => $index + 1,
                    'url' => $path,
                ];
            });

        // ================= LOCALE COMPLETE CHECK =================
        $locales = ['ar', 'en'];
        $localeComplete = [];
        
        foreach ($locales as $loc) {
            // Get translations for each field
            $nameTranslations = $this->getTranslations('name');
            $overviewTranslations = $this->getTranslations('overview');
            $briefTranslations = $this->getTranslations('brief');
            
            // Check if all required fields have translations for this locale
            $projectComplete = 
                !empty($nameTranslations[$loc] ?? null) &&
                !empty($overviewTranslations[$loc] ?? null) &&
                !empty($briefTranslations[$loc] ?? null);
            
            // Check city (if loaded)
            $cityComplete = true;
            if ($this->relationLoaded('city') && $this->city) {
                $cityTranslations = $this->city->getTranslations('name');
                $cityComplete = !empty($cityTranslations[$loc] ?? null);
            }
            
            // Check country (if loaded)
            $countryComplete = true;
            if ($this->relationLoaded('country') && $this->country) {
                $countryTranslations = $this->country->getTranslations('name');
                $countryComplete = !empty($countryTranslations[$loc] ?? null);
            }
            
            // Check services (if loaded)
            $servicesComplete = true;
            if ($this->relationLoaded('services') && $this->services->isNotEmpty()) {
                $servicesComplete = $this->services->every(function ($service) use ($loc) {
                    $serviceTranslations = $service->getTranslations('name');
                    return !empty($serviceTranslations[$loc] ?? null);
                });
            }
            
            // All checks must pass
            $localeComplete[$loc] = $projectComplete && $cityComplete && $countryComplete && $servicesComplete;
        }

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
            'gallery' => $galleryDto ?? [],

            // Relations
            'city' => $this->whenLoaded('city', fn () => [
                'id' => $this->city->id,
                'name' => $this->translateField($this->city->name, $locale),
            ]),

            'country' => $this->whenLoaded('country', fn () => [
                'id' => $this->country->id,
                'name' => $this->translateField($this->country->name, $locale),
            ]),

            'services' => $this->whenLoaded('services', fn () =>
                $this->services->map(fn ($service) => [
                    'id' => $service->id,
                    'name' => $this->translateField($service->name, $locale),
                ])
            ),

            'localeComplete' => $localeComplete,
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
            // Try current locale first
            if (isset($field[$locale])) {
                return $field[$locale];
            }
            
            // Fallback to English
            if (isset($field['en'])) {
                return $field['en'];
            }
            
            // Fallback to Arabic
            if (isset($field['ar'])) {
                return $field['ar'];
            }
            
            // Return first available
            return !empty($field) ? reset($field) : null;
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