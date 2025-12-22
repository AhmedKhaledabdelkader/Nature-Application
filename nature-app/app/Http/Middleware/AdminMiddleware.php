<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // 1️⃣ Get authenticated user (from your AuthenticationMiddleware)
        $user = $request->user();

        if (! $user) {
            return response()->json(['status'=>"error","message" => 'Unauthenticated'], 401);
        }

        // 2️⃣ Check if user has 'admin' role
        if ($user->role !== 'admin') {
            return response()->json(['status'=>"error",'message' => 'Forbidden: Admins only'], 403);
        }

        // 3️⃣ User is admin, allow request
        return $next($request);

        
    }
}
