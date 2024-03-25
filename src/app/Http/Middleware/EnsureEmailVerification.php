<?php

namespace Starmoozie\CRUD\app\Http\Middleware;

use Closure;
use Exception;
use Throwable;

class EnsureEmailVerification
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
        // if the route name is not one of the verification process, run the verification middleware
        if (!in_array($request->route()->getName(), ['verification.notice', 'verification.verify', 'verification.send'])) {
            // the Laravel middleware needs the user resolver to be set with the starmoozie guard
            $userResolver = $request->getUserResolver();
            $request->setUserResolver(function () use ($userResolver) {
                return $userResolver(starmoozie_guard_name());
            });
            try {
                $verifiedMiddleware = new (app('router')->getMiddleware()['verified'])();
            } catch (Throwable) {
                throw new Exception('Missing "verified" alias middleware in App/Http/Kernel.php.');
            }

            return $verifiedMiddleware->handle($request, $next);
        }

        return $next($request);
    }
}
