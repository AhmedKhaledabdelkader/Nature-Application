<?php

namespace App\Traits;

trait HandlesUnlocalized
{

     public function setUnlocalizedFields(object $model, array $data, array $fields)
    {
        
        foreach ($fields as $field) {
            if (isset($data[$field])) {
              
                $model->$field = $data[$field];
            }
        }
    }


    

}
