<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()) {
            return response()->json([
                'error' => 'unothontifed' ]);
            
        }
        if (Auth::user()->role->name == 'admin' || Auth::user()->role->name == 'author' ) {
            return $next($request);
        } else {
            return response()->json([
                'error' => 'you dont have permission'
            ], 403);
        }
    }
}
