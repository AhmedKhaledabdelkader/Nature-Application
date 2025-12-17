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
                'title' => ['required', 'string',"min:3",'max:255'],
                'description' => ['required', 'string',"min:10"],
                'url' => ['required', 'url', 'max:255'],
                'organization_name' => ['required', 'string', 'max:255'],
                'image' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
                'organization_logo' => ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
                'content_file' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
    
        
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
