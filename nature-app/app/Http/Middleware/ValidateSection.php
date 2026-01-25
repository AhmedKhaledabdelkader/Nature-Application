<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ValidateSection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
          $rules = [

            // Basic text fields
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'tagline'=>['required', 'string', 'min:3', 'max:255'],
              
            'subsections' => ['nullable', 'array'],
            'subsections.*.title' => ['required', 'string', 'min:3', 'max:400'],
            'subsections.*.subtitle' => ['nullable', 'string', 'min:3','max:2000'],    
    
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
