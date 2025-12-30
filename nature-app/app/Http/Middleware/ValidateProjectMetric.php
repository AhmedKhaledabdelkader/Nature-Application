<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;


class ValidateProjectMetric
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        
        $rules = [
            'metric_name' => ['required','string','max:255'],
            'metric_value' => ['required','string','max:255'],
            'trend' => ['nullable','in:up,down,stable'],
            'project_id' => ['required','uuid','exists:projects,id'],
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
