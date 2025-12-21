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
            'result' => ['required', 'string', 'min:3'],
            'project_reflected' => ['required', 'string', 'min:3'],

            'start_date' => ['required', 'date_format:j M Y'],
            'end_date' => ['required', 'date_format:j M Y', 'after_or_equal:start_date'],


            // Relations
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

    'service_ids'   => ['required', 'array'], // must be an array
    'service_ids.*' => ['uuid', 'exists:provided__services,id'], // each element must be a valid UUID that exists in services table
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
