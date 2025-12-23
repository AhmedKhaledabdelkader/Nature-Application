<?php

namespace App\Repositories\Eloquents;

use App\Models\Testimonial;
use App\Repositories\Contracts\TestimonialRepositoryInterface;

class TestimonialRepository implements TestimonialRepositoryInterface
{

    public function create(array $data)
    {
        return Testimonial::create($data) ;
    }


    public function find(string $id){


     return Testimonial::find($id) ;

    }




     public function delete(string $id): bool
    {
        $testimonial = Testimonial::find($id);

        if ($testimonial) {
            return $testimonial->delete();
        }

        return false;
    }


    public function all($page, $size){


    return Testimonial::query()->paginate($size,['*'],'page',$page);



    }


}
