<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $levels): Response
    {
        $userLevel = auth()->user()->level;
        $allowedLevels = explode('|', $levels);

        if (in_array($userLevel, $allowedLevels)) {
            return $next($request);
        }

        return redirect("/dashboard");
    }
}
