<?php

namespace App\Services;

use App\Repositories\Contracts\SectionRepositoryInterface;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Psy\Util\Str;

class SectionService
{

    public $sectionRepository ;

    use LocalizesData,HandlesLocalization,HandlesUnlocalized ;


    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository=$sectionRepository ;
    }




public function addSectionWithSubsections(array $data){


 $locale = app()->getLocale();

   $this->localizeFields($data,['name','tagline'],$locale);

   $data['locale']=$locale ;

  return $this->sectionRepository->createWithSubsections($data) ;



}


/*
public function updateSectionWithSubsections(array $data, string $id)
{
    // Find the Section

    $section = $this->sectionRepository->find($id);
  
    if (!$section) {
        return null;
    }

    $locale = app()->getLocale();

    // Update Section localized fields
    $this->setLocalizedFields($section, $data, ['name', 'tagline'], $locale);
 
    $section->save();
  

    // Process subsections
    if (!empty($data['subsections'])) {
    
        foreach ($data['subsections'] as $sub) {

            // Case 1: Only id sent → delete this subsection
            if (isset($sub['id']) && empty($sub['title']) && empty($sub['subtitle'])) {
                $subsection = $section->subsection->firstWhere('id', $sub['id']);
             
                if ($subsection) {
                   // ONLY DELETE CURRENT LOCALE
   
                }
                continue;
            }

            // Case 2: id + localized fields → update existing subsection
            if (isset($sub['id']) && (!empty($sub['title']) || !empty($sub['subtitle']))) {
                $subsection = $section->subsection->firstWhere('id', $sub['id']);
                if ($subsection) {
                    $this->setLocalizedFields($subsection, $sub, ['title', 'subtitle'], $locale);
                    $subsection->save();
                }
                continue;
            }

            // Case 3: No id → create new subsection
            if (!isset($sub['id'])) {
                $this->localizeFields($sub, ['title', 'subtitle'], $locale);
                $section->subsection()->create($sub);
            }
        }
    }

    return $section->load('subsection'); // eager load subsections navigation property
}*/


public function updateSectionWithSubsections(array $data, string $id)
{
    // Find the Section
    $section = $this->sectionRepository->find($id);
    
    if (!$section) {
        return null;
    }

    $locale = app()->getLocale();

   
    $this->setLocalizedFields($section, $data, ['name', 'tagline'], $locale);

    $this->setUnlocalizedFields($section, $data, ['subsection_publish','subsections_publish_locales']);


    $section->save();

   
    if (!empty($data['subsections'])) {
        foreach ($data['subsections'] as $sub) {
            // Check if id exists
            if (isset($sub['id'])) {
                $subsection = $section->subsection->firstWhere('id', $sub['id']);
                
                if (!$subsection) {
                    continue; // Subsection not found, skip
                }
                
                // Check if we need to delete or update
                $hasTitle = isset($sub['title']) && trim($sub['title']) !== '';
                $hasSubtitle = isset($sub['subtitle']) && trim($sub['subtitle']) !== '';
                
                if (!$hasTitle && !$hasSubtitle) {
                    // DELETE: No content provided for current locale
                    $subsection->forgetTranslation('title', $locale);
                    $subsection->forgetTranslation('subtitle', $locale);
                    
                    // Check if any translations remain
                    $remainingTitle = array_filter($subsection->getTranslations('title'), function($value) {
                        return trim($value) !== '';
                    });
                    
                    $remainingSubtitle = array_filter($subsection->getTranslations('subtitle'), function($value) {
                        return trim($value) !== '';
                    });
                    
                    if (empty($remainingTitle) && empty($remainingSubtitle)) {
                        $subsection->delete();
                    } else {
                        $subsection->save();
                    }
                } else {
                    // UPDATE: Has content for current locale
                    if ($hasTitle) {
                        $subsection->setTranslation('title', $locale, $sub['title']);
                    }
                    if ($hasSubtitle) {
                        $subsection->setTranslation('subtitle', $locale, $sub['subtitle']);
                    }
                    $subsection->save();
                }
            } else {
                
             
                
                $hasTitle = isset($sub['title']) && trim($sub['title']) !== '';
                $hasSubtitle = isset($sub['subtitle']) && trim($sub['subtitle']) !== '';
                
                if ($hasTitle || $hasSubtitle) {
                    $this->localizeFields($sub, ['title', 'subtitle'], $locale);
                    $section->subsection()->create($sub);
                }
            }
        }
    }

    return $section->load('subsection');
}




public function findSectionWithSubsections(string $id){


    return $this->sectionRepository->find($id) ;





}





















}
