<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
   public function toArray(Request $request): array
    {
        $locale = app()->getLocale();

        // 1️⃣ Check if subsections globally published
        if (!$this->subsection_publish) {
            $subsections = collect(); // all hidden
        } else {
            // 2️⃣ Filter by section-level locale
            $allowedLocales = $this->subsections_publish_locales ?? [];
            if (!empty($allowedLocales) && !in_array($locale, $allowedLocales)) {
                $subsections = collect(); // current locale not allowed
            } else {
                // 3️⃣ Filter subsections individually
                $subsections = $this->whenLoaded('subsection')->filter(function ($sub) use ($locale) {
                    $published = $sub->is_published ?? true;
                    $localeCheck = empty($sub->publish_locales) || in_array($locale, $sub->publish_locales);
                    return $published && $localeCheck;
                });
            }
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'tagline' => $this->tagline,
            'subsections' => SubsectionResource::collection(
                $subsections->map(function ($sub) use ($locale) {
                    $sub->title = $sub->title;
                    $sub->subtitle = $sub->subtitle;
                    return $sub;
                })
            ),
            'createdAt' => $this->created_at?->format('d/m/Y'),
            'updatedAt' => $this->updated_at?->format('d/m/Y'),
        ];
    }
}
