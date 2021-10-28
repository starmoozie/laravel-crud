<?php

namespace Starmoozie\CRUD\app\Http\Middleware;

use Closure;

class UseStarmoozieAuthGuardInsteadOfDefaultAuthGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        app('auth')->setDefaultDriver(config('starmoozie.base.guard'));

        return $next($request);
    }
}
