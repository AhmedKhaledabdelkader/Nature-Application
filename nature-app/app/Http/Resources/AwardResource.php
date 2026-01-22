<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class AwardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        // Build DTO for organization logos (array of paths)
        $logosDto = collect($this->organizations_logos ?? [])
            ->values()
            ->map(function ($path, $index) {

                return [
                    'id'  => $index+1,
                    'url' => $path,
                ];
            });

        return [
            'id' => $this->id,

            'name' => $this->name,

            'description' => $this->description,

            
            'image' => $this->image??null,

          
            'organizationLogos' => $logosDto,

            'year' => $this->year,

            'status' => $this->status,

            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,

            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
    }
}

