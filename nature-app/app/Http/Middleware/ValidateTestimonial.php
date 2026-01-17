<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateTestimonial
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        
       $rules = [

    // Client Name
    'client_name_en' => 'nullable|string|min:2|max:255',
    'client_name_ar' => 'nullable|string|min:2|max:255',

    // Job Title
    'job_title_en' => 'nullable|string|min:2|max:255',
    'job_title_ar' => 'nullable|string|min:2|max:255',

    // Testimonial (text fields)
    'testimonial_en' => 'nullable|string|min:5|max:5000',
    'testimonial_ar' => 'nullable|string|min:5|max:5000',

];


            
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }





        return $next($request);




        
    }
}
