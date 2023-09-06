<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class isSuperAdminAndAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check())
        {
            if($request->user()->isAdmin() || $request->user()->isSuperAdmin())
            {
                return $next($request);
            }

            return redirect()->back()->withErrors(['errors' => 'You dont have enough Authorization to access this page.']);
        }
    }
}
