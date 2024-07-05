<?php

namespace App\Http\Middleware;

use App\Enums\GeneralStatus;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsEnabled
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
        if (Auth::check() && Auth::user()->status !== GeneralStatus::Enabled) {
            Auth::logout();
            return redirect()->back()->with('info', 'This account has been deactivated. Please Contact Admin');
        }
        return $next($request);
    }
}
