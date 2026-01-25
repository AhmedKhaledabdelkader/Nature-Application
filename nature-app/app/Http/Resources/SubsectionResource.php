<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubsectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[

       
           'id' => $this->id,

            'title' => $this->title,

            'subtitle' => $this->subtitle,

            
            // Dates formatted
            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,

            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,


        ];
    }
}
