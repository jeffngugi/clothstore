<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Http\Controllers\APIController;

class checkAdmin extends APIController
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->role_id != 1){
            // return $this->responseUnauthorized('You are not authorized to perform this request');
            return response()->json([
                'status' => 401,
                'error' => 'You are not authorized to perform this request',
            ], 401);
        }
        return $next($request);
    }
}
