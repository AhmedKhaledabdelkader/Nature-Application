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
    
                
                'locale'=> ['sometimes', 'in:ar,en'],
                'title' => ['required', 'string',"min:3",'max:400'],
                'sub_title' => ['required', 'string',"min:3",'max:400'],
                'color' => ['required', 'string',"min:2",'max:200'],
               

    
        
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
