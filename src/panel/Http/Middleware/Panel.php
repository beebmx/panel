<?php

namespace Beebmx\Panel\Http\Middleware;

use Closure;
use Auth;
use App\Profile;

class Panel
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
        $profile = Auth::user()->profile;
        if (!$profile->is_admin && !$profile->has_panel) {
            Auth::logout();
            return redirect(config('panel.prefix').'/login');
        }
        return $next($request);
    }
}
