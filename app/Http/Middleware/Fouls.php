<?php

namespace App\Http\Middleware;

use App\Models\UserSystem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Fouls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (UserSystem::where('user_id', Auth::user()->id)->first()->system_id == 2) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
