<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateAward
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


            $rules = [
    
                
            'locale'=> ['sometimes', 'in:ar,en'],
            'name' => ['required', 'string',"min:3",'max:255'],
            'description' => ['required', 'string',"min:10"],
            'year' => ['required', 'integer', 'digits:4', 'min:1900', 'max:' . (date('Y') + 1)],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
            'status' => ['sometimes', 'boolean'],
            'organizations_logos' => ['required', 'array', 'min:1'],
            'organizations_logos.*' => [
                'image',
                'mimes:jpeg,png,jpg,webp',
                'max:3072'
            ],

              
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
