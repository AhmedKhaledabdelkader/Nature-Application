<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        return [
            'id' => $this->id,

            'name' => $this->name
                ? $this->getTranslation('name', $locale)
                : null,

            'tagline' => $this->tagline
                ? $this->getTranslation('tagline', $locale)
                : null,

            'steps' => $this->formatSteps($locale),
            'benefits' => $this->formatBenefits($locale),
            'values' => $this->formatValues($locale),
            'impacts' => $this->formatImpacts($locale),


            'status' => $this->status,

            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,

            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
    }

    // =====================================================
    // TRANSLATION HELPER (CORE FIX)
    // =====================================================

    private function translateField($field, string $locale)
    {
        if (is_array($field)) {

        $fallback = $locale === 'en' ? 'ar' : 'en';

       return $field[$locale] ?? $field[$fallback]??null;


          
        }

        return $field ?? null;
    }

    // =====================================================
    // STEPS
    // =====================================================

    private function formatSteps(string $locale): array
    {
        if (empty($this->steps)) return [];

        return collect($this->steps)
            ->sortBy('order')
            ->values()
            ->map(fn ($step) => [

                'id' => $step['id'] ?? null,

                'title' => $this->translateField(
                    $step['title'] ?? null,
                    $locale
                ),

                'description' => $this->translateField(
                    $step['description'] ?? null,
                    $locale
                ),

                'image' => $step['image'] ?? null,

                'order' => $step['order'] ?? null,

            ])
            ->toArray();
    }

    // =====================================================
    // BENEFITS
    // =====================================================

    private function formatBenefits(string $locale): array
    {
        if (empty($this->benefits)) return [];

        return collect($this->benefits)
            ->map(fn ($benefit) => [

                'id' => $benefit['id'] ?? null,

                'title' => $this->translateField(
                    $benefit['title'] ?? null,
                    $locale
                ),

                'tagline' => $this->translateField(
                    $benefit['tagline'] ?? null,
                    $locale
                ),

                'body' => $this->translateField(
                    $benefit['body'] ?? null,
                    $locale
                ),

                'insights' => collect($benefit['insights'] ?? [])
                    ->map(fn ($insight) => [
                        
                        'id'=>$insight["id"]??null,
                        'metricTitle' => $this->translateField(
                            $insight['metric_title'] ?? null,
                            $locale
                        ),

                        'metricNumber' => $insight['metric_number'] ?? null,

                    ])
                    ->toArray(),

            ])
            ->toArray();
    }

    // =====================================================
    // VALUES
    // =====================================================

    private function formatValues(string $locale): array
    {
        if (empty($this->values)) return [];

        return collect($this->values)
            ->map(fn ($value) => [

                'id' => $value['id'] ?? null,

                'title' => $this->translateField(
                    $value['title'] ?? null,
                    $locale
                ),

                'description' => $this->translateField(
                    $value['description'] ?? null,
                    $locale
                ),

                 'tools' => $this->translateField(
                    $value['tools'] ?? null,
                    $locale
                ),

            

            ])
            ->toArray();
    }

    // =====================================================
    // IMPACTS
    // =====================================================

    private function formatImpacts(string $locale): array
    {
        if (empty($this->impacts)) return [];

        return collect($this->impacts)
            ->map(fn ($impact) => [

                'id' => $impact['id'] ?? null,

                'title' => $this->translateField(
                    $impact['title'] ?? null,
                    $locale
                ),

                'description' => $this->translateField(
                    $impact['description'] ?? null,
                    $locale
                ),

                'image' => $impact['image'] ?? null,

            ])
            ->toArray();
    }
}
