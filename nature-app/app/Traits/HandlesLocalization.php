<?php

namespace App\Traits;

trait HandlesLocalization
{

    public function setLocalizedFields(object $model, array $data, array $fields,string $locale)
    {
        
        foreach ($fields as $field) {
            if (isset($data[$field])) {
              
                $model->setLocalizedValue($field, $locale, $data[$field]);
            }
        }
    }





    
}
