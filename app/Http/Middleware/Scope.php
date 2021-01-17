<?php

namespace App\Http\Middleware;


class Scope
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
        // Only Admin can enter. User Role is id = 1
        if (auth()->user()->role_id !== 1) {
            return redirect()->to('/dashboard');
        }

        return $next($request);
    }
}
