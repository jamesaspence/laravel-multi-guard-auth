<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Auth\AuthenticationException;

class HasRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $role
     * @return mixed
     */
    public function handle($request, Closure $next, string $role)
    {
        /** @var User $user */
        $user = $request->user();

        if (is_null($user) || !$user->hasRole($role)) {
            $this->throwAuthException();
        }

        return $next($request);
    }

    private function throwAuthException()
    {
        throw new AuthenticationException('Unauthenticated.');
    }
}
