<?php

namespace App\Services;

use App\Repositories\Contracts\TestimonialRepositoryInterface;
use App\Traits\HandlesLocalization;
use App\Traits\HandlesUnlocalized;
use App\Traits\LocalizesData;
use Illuminate\Support\Facades\App;

class TestimonialService
{

     use HandlesLocalization,LocalizesData,HandlesUnlocalized ;


    public $testimonialRepository ;
   
    public function __construct(TestimonialRepositoryInterface $testimonialRepository)
    {
        $this->testimonialRepository=$testimonialRepository ;
    
    }



    public function addTestimonial(array $data){
                
    $locale = app()->getLocale();

    $this->localizeFields($data,['feedback','job_title'],$locale);

   return $this->testimonialRepository->create($data) ;


    }


    public function updateTestimonial(string $id,array $data){


    $locale = app()->getLocale();


$testimonial = $this->testimonialRepository->find($id);

    if (!$testimonial) {
        return null;
    }

    $this->setLocalizedFields($testimonial, $data, ['feedback','job_title'],$locale);
    
    $this->setUnlocalizedFields($testimonial, $data, ['name','company_name']);

   $testimonial->save() ;

   return $testimonial;



    }





public function getAllTestimonials(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;

    return $this->testimonialRepository->all($page, $size);
}


public function findTestimonial(string $id){


    $testimonial=$this->testimonialRepository->find($id) ;

    if (!$testimonial) {
        
        return null;
    }

    return $testimonial ;




}











}
