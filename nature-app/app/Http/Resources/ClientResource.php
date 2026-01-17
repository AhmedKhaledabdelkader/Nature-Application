<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
  public function toArray(Request $request): array
    {
        $locale = app()->getLocale(); // 'ar' or 'en'

        return [
            'id'   => $this->id,
            'name' => $this->{"name_{$locale}"},
            'image' => $this->image,
            'status'=>$this->status,
            
            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,
            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
    }
}
