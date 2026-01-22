<?php

namespace App\Services;

use App\Repositories\Contracts\TestimonialSectionRepositoryInterface;
use App\Traits\HandlesUnlocalized;

class TestimonialSectionService
{
    use HandlesUnlocalized ;
    
    public $testimonialSectionRepository;


    public function __construct(TestimonialSectionRepositoryInterface $testimonialSectionRepository)
    {
        $this->testimonialSectionRepository = $testimonialSectionRepository;
    }


    public function createTestimonialSection(array $data)
    {
        return $this->testimonialSectionRepository->create($data);
    }


      public function updateTestimonialSection(string $id, array $data)

{

    $testimonial = $this->testimonialSectionRepository->find($id);

    if (!$testimonial) {
        return null;
    }

    $this->setUnlocalizedFields($testimonial, $data,['client_name_en','client_name_ar','job_title_en','job_title_ar',
    "testimonial_en","testimonial_ar","status"]);   
    $testimonial->save();

    return $testimonial;
}




public function getAllTestimonialSections(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;

    return $this->testimonialSectionRepository->getAll($page, $size);


}

public function searchTestimonialSections(array $data)
{
    $size = $data['size'] ?? 10;
    $page = $data['page'] ?? 1;
    $key= $data['key'] ?? 'client_name';
    $value= $data['value'] ?? '';

    return $this->testimonialSectionRepository->search($key,$value, $page, $size);


}






public function deleteTestimonialSection(string $id)
{
    $testimonial = $this->testimonialSectionRepository->find($id);
    
    if (!$testimonial) {
        return false;
    }
    
  
    
    return $this->testimonialSectionRepository->delete($id);
}




public function findTestimonial(string $id){



    $testimonial=$this->testimonialSectionRepository->find($id);
     
      if (!$testimonial) {
        return false;
    }

    return $testimonial ;




}




  
}
