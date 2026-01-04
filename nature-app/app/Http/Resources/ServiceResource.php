<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'subTitle'=>$this->sub_title,
            'color'=>$this->color,
            'steps' => StepResource::collection($this->whenLoaded('steps')),
            'createdAt' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updatedAt' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];

  
    }

    
    public function onlyIdAndTitle(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }


}
