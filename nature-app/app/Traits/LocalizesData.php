<?php

namespace App\Traits;

trait LocalizesData
{

     public function localizeFields(array &$data, array $fields,string $locale)
    {
        

        foreach ($fields as $field) {
          
                $data[$field] = [
                    $locale => $data[$field] ?? null,
                ];
            
        }
    }



    
}
