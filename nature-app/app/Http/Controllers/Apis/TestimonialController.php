<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Services\TestimonialService;
use Illuminate\Http\Request;



class TestimonialController extends Controller
{
  public  $testimonialService ;

    public function __construct(TestimonialService $testimonialService) {
    

        $this->testimonialService=$testimonialService;


    }


    public function store(Request $request){


     $testimonial = $this->testimonialService->addTestimonial($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial created successfully',
            'result' => new TestimonialResource($testimonial)
        ], 201);
        
    }


       public function update(Request $request, string $id)
    {
        $testimonial = $this->testimonialService->updateTestimonial(
            $id,
            $request->all()
        );

        if (!$testimonial) {
            return response()->json([
                'status'=>'error',
                'message' => 'Testimonial not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Testimonial updated successfully',
            'result' => new TestimonialResource($testimonial)
        ], 200);
    }



     public function index(Request $request)
    {
        $testimonials = $this->testimonialService->getAllTestimonials($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'testimonials retrieved successfully',
            'result' => TestimonialResource::collection($testimonials)
        ]);
    }


    public function show(Request $request,string $id){


        $testimonial=$this->testimonialService->findTestimonial($id) ;

        if (!$testimonial) {
            

             return response()->json([
                'status'=>'error',
                'message' => 'Testimonial not found'
            ], 404);


        }


        return response()->json([

             'status' => 'success',
            'message' => 'testimonials retrieved successfully',
            'result' => new TestimonialResource($testimonial) 


        ]) ;


    }






    
}
