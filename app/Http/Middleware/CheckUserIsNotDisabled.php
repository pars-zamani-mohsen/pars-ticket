<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserIsNotDisabled
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check() && Auth::user()->hasRole('disable')) {
            Auth::logout();

            return redirect()->route('login')->with('error', __('general.disabled_user_message'));
        }

        return $next($request);
    }
}
