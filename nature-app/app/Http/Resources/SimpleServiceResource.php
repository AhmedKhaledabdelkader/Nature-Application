<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleServiceResource extends JsonResource
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
            $taglineTranslations = $this->getTranslations('tagline');
        
            
            // Check if all required fields have translations for this locale
            $serviceComplete = 
                !empty($nameTranslations[$loc] ?? null) &&
                !empty($taglineTranslations[$loc] ?? null) ;
               
             $localeComplete[$loc] = $serviceComplete;

        }


          return [
            'id' => $this->id,
            'name' => $this->name,
            'tagline' => $this->tagline,
            'status'=>$this->status,
            'localeComplete' => $localeComplete,
            'createdAt' => $this->created_at
                ? $this->created_at->format('d/m/Y')
                : null,
            'updatedAt' => $this->updated_at
                ? $this->updated_at->format('d/m/Y')
                : null,
       
        ];
        
    
    }


    
    public function onlyIdAndName(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }




    }
