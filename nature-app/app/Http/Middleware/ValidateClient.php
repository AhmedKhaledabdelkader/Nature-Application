<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ValidateClient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

          $rules = [
    
                
                
                'name_en' => ['nullable', 'string',"min:3",'max:255'],
                'name_ar' => ['nullable', 'string',"min:3",'max:255'],
                'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:3072'],//5120
        
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
