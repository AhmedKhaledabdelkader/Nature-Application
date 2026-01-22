<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Repositories\Contracts\TestimonialSectionRepositoryInterface;
use App\Services\TestimonialSectionService;
use Illuminate\Http\Request;



class TestimonialSectionController extends Controller
{

    public $testimonialSectionService ;
    public function __construct(TestimonialSectionService $testimonialSectionService) {

        $this->testimonialSectionService=$testimonialSectionService ;
    }


    public function store(Request $request){


        $testimonialSection = $this->testimonialSectionService->createTestimonialSection($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial created successfully',
            'result' => $testimonialSection
        ], 201);

    }

    public function update(string $id,Request $request){

        $testimonialSection = $this->testimonialSectionService->updateTestimonialSection($id,$request->all());

        if (!$testimonialSection) {
            return response()->json([
                'status' => 'error',
                'message' => 'Testimonial not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Testimonial updated successfully',
            'result' => $testimonialSection
        ], 200);


    }

 
public function index(Request $request){

    $testimonials = $this->testimonialSectionService->getAllTestimonialSections($request->all());

    return response()->json([
        'status' => 'success',
        'message' => 'testimonials retrieved successfully',
        'result' =>  TestimonialResource::collection($testimonials)
    ], 200);

    
}


public function show(Request $request,string $id){

    $testimonial = $this->testimonialSectionService->findTestimonial($id);


    if (!$testimonial) {
        return response()->json([
            'status' => 'error',
            'message' => 'Testimonial not found'
        ], 404);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Testimonial retrieved successfully',
        'result' => (new TestimonialResource($testimonial))->allData()
    ], 200);

    
}










public function search(Request $request){

    $testimonials = $this->testimonialSectionService->searchTestimonialSections($request->all());

    return response()->json([
        'status' => 'success',
        'message' => 'testimonials retrieved successfully',
        'result' =>  TestimonialResource::collection($testimonials),
        'page' => $testimonials->currentPage(),
        'size' => $testimonials->perPage(),
        'total' => $testimonials->total(),
        'lastPage' => $testimonials->lastPage(),

    ], 200);

    
}



public function destroy(string $id)
{
    
        $deleted = $this->testimonialSectionService->deleteTestimonialSection($id);
        
        if (!$deleted) {
            return response()->json([

                'status' => 'error',
                'message' => 'Testimonial not found'
                
            ], 404);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'testimonial deleted successfully'
        ]);
    
}









    
}
