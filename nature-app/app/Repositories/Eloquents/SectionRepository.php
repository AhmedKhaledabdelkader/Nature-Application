<?php

namespace App\Repositories\Eloquents;

use App\Models\Section;
use App\Repositories\Contracts\SectionRepositoryInterface;
use App\Traits\LocalizesData;

class SectionRepository implements SectionRepositoryInterface

{

    use LocalizesData ;

    
    public function createWithSubsections(array $data) {
        
        $section = Section::create(['name' => $data['name'],'tagline'=>$data['tagline']]);

        if (!empty($data['subsections'])) {

            foreach ($data['subsections'] as $sub) {

                  $this->localizeFields($sub,['title','subtitle'],$data['locale']);

                $section->subsection()->create($sub);
            }
        }

        return $section->load('subsection');
   
}


public function find(string $id)
{
    return Section::with('subsection')->find($id);
}





}