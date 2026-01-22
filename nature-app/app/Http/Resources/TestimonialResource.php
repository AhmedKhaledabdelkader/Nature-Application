<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'clientName' => $this->{"client_name_{$locale}"},
            'jobTitle' => $this->{"job_title_{$locale}"},
            'Testimonial' => $this->{"testimonial_{$locale}"},
            'status'=>$this->status,
            
            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,
            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
        ];
        
    }


      public function allData(): array
    {
        return [
            'id' => $this->id,
            'client_name_en' => $this->client_name_en,
            'client_name_ar'=>$this->client_name_ar,
            'job_title_en' => $this->job_title_en,
            'job_title_ar'=>$this->job_title_ar,
            'testimonial_en'=>$this->testimonial_en,
            'testimonial_ar'=>$this->testimonial_ar,
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
