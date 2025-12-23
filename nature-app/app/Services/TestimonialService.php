<?php

namespace App\Services;

use App\Repositories\Contracts\TestimonialRepositoryInterface;
use Illuminate\Support\Facades\App;

class TestimonialService
{

    public $testimonialRepository ;
   
    public function __construct(TestimonialRepositoryInterface $testimonialRepository)
    {
        $this->testimonialRepository=$testimonialRepository ;
    
    }



    public function addTestimonial(array $data){
                
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);  

    $data['feedback'] = [
       $locale => $data['feedback'] ?? null,
    ];

    $data['job_title'] = [
       $locale => $data['job_title'] ?? null,
    ];


   return $this->testimonialRepository->create($data) ;


    }


    public function updateTestimonial(string $id,array $data){


$testimonial = $this->testimonialRepository->find($id);

    if (!$testimonial) {
        return null;
    }

    
    $locale = $data['locale'] ?? 'en';
    App::setLocale($locale);

   
    if (isset($data['feedback'])) {
        $testimonial->setLocalizedValue('feedback', $locale, $data['feedback']);
    }


    if (isset($data['name'])) {
    $testimonial->name=$data["name"];
    }


    if (isset($data['company_name'])) {
    $testimonial->company_name=$data["company_name"];
    } 

     


      if (isset($data['job_title'])) {
        $testimonial->setLocalizedValue('job_title', $locale, $data['job_title']);
    }

    


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
