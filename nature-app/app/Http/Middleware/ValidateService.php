<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateService
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $rules = [

            // Base fields
            'locale' => ['sometimes', 'in:ar,en'],
            'name' => ['required', 'string', 'min:3', 'max:400'],
            'tagline' => ['required', 'string', 'min:3', 'max:400'],

            
            'steps' => ['nullable', 'array'],
            'steps.*.title' => ['required', 'string', 'min:3', 'max:400'],
            'steps.*.description' => ['required', 'string', 'min:3'],       
            'steps.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],


            'benefits' => ['nullable', 'array'],
            'benefits.*.title' => ['required', 'string', 'min:3'],         
            'benefits.*.tagline' => ['required', 'string', 'min:3'],
            'benefits.*.body' => ['required', 'string', 'min:3'],
           'benefits.*.insights' => ['nullable', 'array'],        
            'benefits.*.insights.*.metric_title' => ['required', 'string', 'min:1'],
            'benefits.*.insights.*.metric_number' => ['required', 'numeric'],

            // Values
            'values' => ['nullable', 'array'],
            'values.*.title' => ['required', 'string', 'min:3'],
            'values.*.description' => ['required', 'string', 'min:3'],
            'values.*.tools' => ['nullable', 'array'],
            'values.*.tools.*' => ['string'],

            // Impacts
            'impacts' => ['nullable', 'array'],
            'impacts.*.title' => ['required', 'string', 'min:3'],
            'impacts.*.description' => ['required', 'string', 'min:3'],
            'impacts.*.image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:5120'],

            // Optional fields
            'status' => ['sometimes', 'boolean'],
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


