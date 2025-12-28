<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AwardResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,  
            'image' => $this->image,
            'organizationName' => $this->organization_name,
            'organizationLogo' => $this->organization_logo,
            'url' => $this->url,
            'contentFile' => $this->content_file,
             'sponsors' => SponsorResource::collection(
                $this->whenLoaded('sponsors')
            ),
            'createdAt' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
        
    }
}
