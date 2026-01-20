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

/*

     public function mergeLocalizedFields(array &$data, array $fields, string $locale, ?array $existing = null): void
    {
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                // If there's existing data for this field, merge it
                if ($existing && isset($existing[$field]) && is_array($existing[$field])) {
                    $data[$field] = array_merge($existing[$field], [
                        $locale => $data[$field]
                    ]);
                } else {
                    // No existing data, just set current locale
                    $data[$field] = [
                        $locale => $data[$field],
                    ];
                }
            }
        }
    }*/
/*
public function mergeLocalizedFields(array &$incoming, array $fields, string $locale, ?array $existing = null): void
{
    foreach ($fields as $field) {
        if (!isset($incoming[$field])) {
            continue;
        }

        // Start with existing translations if any
        $translations = [];
        if ($existing && isset($existing[$field]) && is_array($existing[$field])) {
            $translations = $existing[$field];
        }

        // Merge/overwrite current locale
        $translations[$locale] = $incoming[$field];

        // Assign back
        $incoming[$field] = $translations;
    }
}
*/



public function mergeLocalizedFields(array &$data, array $fields, string $locale, ?array $existing = null): void
{
    foreach ($fields as $field) {

        // If the key exists and value is null → remove that locale only
        if (array_key_exists($field, $data) && $data[$field] === null) {
            if ($existing && isset($existing[$field][$locale])) {
                unset($existing[$field][$locale]);
            }
            $data[$field] = $existing[$field] ?? [];
            continue;
        }

        // Normal merge for updating locale
        if (isset($data[$field])) {
            if ($existing && isset($existing[$field]) && is_array($existing[$field])) {
                $data[$field] = array_merge($existing[$field], [
                    $locale => $data[$field]
                ]);
            } else {
                $data[$field] = [
                    $locale => $data[$field]
                ];
            }
        }
    }
}













    
}
