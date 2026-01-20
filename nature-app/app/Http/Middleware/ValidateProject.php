<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateProject
{
    public function handle(Request $request, Closure $next): Response
    {
        $rules = [

            // Basic text fields
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'overview' => ['required', 'string', 'min:10'],
            'brief' => ['required', 'string', 'min:10'],

           'start_date' => ['required', 'date_format:d/m/Y'],
            'end_date' => ['nullable', 'date_format:d/m/Y', 'after_or_equal:start_date'],


            'country_id' => ['required', 'uuid', 'exists:countries,id'],
            'city_id' => ['required', 'uuid', 'exists:cities,id'],

            // Single images
            'image_before' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],

            'image_after' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],

            // Gallery
            'gallery' => ['required', 'array', 'min:1'],
            'gallery.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:2048'
            ],

              
            'results' => ['nullable', 'array'],
            'results.*.section_title' => ['required', 'string', 'min:3', 'max:400'],
            'results.*.section_body' => ['required', 'string', 'min:3','max:10000'],    
            
            
            'metrics' => ['nullable', 'array','max:3'],
            'metrics.*.metric_title' => ['required', 'string', 'min:2', 'max:400'],
            'metrics.*.metric_number' => ['required', 'string', 'min:1','max:300'],   
            'metrics.*.metric_case' => ['required', 'string', 'min:2','max:300'], 

    'service_ids'   => ['required', 'array'], // must be an array
    'service_ids.*' => ['uuid', 'exists:service_v2_s,id'], // each element must be a valid UUID that exists in services table
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
