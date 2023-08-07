<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthenticateWebHook
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if (env('WEBHOOK_USUARIO') === $request->getUser() &&
            env('WEBHOOK_CONTRASENA') === $request->getPassword()) {
            return $next($request);
        }

        return response('No autorizado', 401);

    }
}
