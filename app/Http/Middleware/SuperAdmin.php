<?php

namespace App\Http\Middleware;


class SuperAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, \Closure $next)
    {
        // Only Admin can enter. Super Admin Role is id = 3
        if (auth()->user()->role_id !== 3) {
            return redirect()->to('/dashboard');
        }

        return $next($request);
    }
}
