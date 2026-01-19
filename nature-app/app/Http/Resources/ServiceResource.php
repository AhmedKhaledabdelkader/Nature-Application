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
            'name' => $this->name ? $this->getTranslation('name', $locale) : null,
            'tagline' => $this->tagline ? $this->getTranslation('tagline', $locale) : null,

            'steps' => $this->formatSteps($locale),
            'benefits' => $this->formatBenefits($locale),
            'values' => $this->formatValues($locale),
            'impacts' => $this->formatImpacts($locale),

            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,
            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
    }

    private function formatSteps(string $locale): array
    {
        if (!$this->steps) return [];

        return collect($this->steps)
            ->sortBy('order')
            ->values()
            ->map(fn($step) => [
                'title' => is_array($step['title']) ? ($step['title'][$locale] ?? null) : $step['title'],
                'description' => is_array($step['description']) ? ($step['description'][$locale] ?? null) : $step['description'],
                'image' => $step['image'] ?? null,
                'order' => $step['order'] ?? null,
            ])
            ->toArray();
    }

    private function formatBenefits(string $locale): array
    {
        if (!$this->benefits) return [];

        return collect($this->benefits)
            ->map(fn($benefit) => [
                'title' => is_array($benefit['title']) ? ($benefit['title'][$locale] ?? null) : $benefit['title'],
                'tagline' => is_array($benefit['tagline']) ? ($benefit['tagline'][$locale] ?? null) : $benefit['tagline'],
                'body' => is_array($benefit['body']) ? ($benefit['body'][$locale] ?? null) : $benefit['body'],
                'insights' => collect($benefit['insights'] ?? [])->map(fn($insight) => [
                    'metricTitle' => is_array($insight['metric_title']) ? ($insight['metric_title'][$locale] ?? null) : $insight['metric_title'],
                    'metricNumber' => $insight['metric_number'] ?? null,
                ])->toArray(),
            ])
            ->toArray();
    }

    private function formatValues(string $locale): array
    {
        if (!$this->values) return [];

        return collect($this->values)
            ->map(fn($value) => [
                'title' => is_array($value['title']) ? ($value['title'][$locale] ?? null) : $value['title'],
                'description' => is_array($value['description']) ? ($value['description'][$locale] ?? null) : $value['description'],
                'tools' => $value['tools'] ?? [], // plain array of strings
            ])
            ->toArray();
    }

    private function formatImpacts(string $locale): array
    {
        if (!$this->impacts) return [];

        return collect($this->impacts)
            ->map(fn($impact) => [
                'title' => is_array($impact['title']) ? ($impact['title'][$locale] ?? null) : $impact['title'],
                'description' => is_array($impact['description']) ? ($impact['description'][$locale] ?? null) : $impact['description'],
                'image' => $impact['image'] ?? null,
            ])
            ->toArray();
    }
}
