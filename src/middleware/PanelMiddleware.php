<?php

namespace Beebmx\Panel;

use Closure;
use Auth;
use App\Profile;

class PanelMiddleware
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
        if (!(int)$profile->is_admin && !(int)$profile->has_panel) {
            Auth::logout();
            return redirect(config('panel.prefix').'/login');
        }
        return $next($request);
    }
}
