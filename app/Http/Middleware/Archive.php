<?php

namespace App\Http\Middleware;

use App\Models\UserSystem;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Archive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        foreach (UserSystem::where('user_id', Auth::user()->id)->get() as $userSystem) {
            if ($userSystem->system_id == 2) {
                return $next($request);
            }
        }
        return redirect()->back();
    }
}
