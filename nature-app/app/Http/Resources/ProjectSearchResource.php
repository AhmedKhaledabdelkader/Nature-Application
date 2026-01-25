<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectSearchResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        
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
            'name' => $this->name,
            'image'=>$this->image_after,
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

            'localeComplete' => $localeComplete,
            
            'status'=>$this->status


        ];
    }
}
